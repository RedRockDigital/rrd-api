<?php

namespace RedRockDigital\Api\Services\Payments\Providers\Stripe;

use RedRockDigital\Api\Services\Payments\PaymentsInterface;
use RedRockDigital\Api\Models\{
    Subscription,
    Team
};
use RedRockDigital\Api\Services\Payments\Providers\Provider;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\Enums\StripeMode;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions\{
    AddSubscriptionFailedException,
    ChangeSubscriptionFailedException,
    CustomerNotLocatedException,
    DecreaseSubscriptionFailedException,
    DuplicateSubscriptionItem,
    IncreaseSubscriptionFailedException,
    NoSubscriptionException,
    ResumeSubscriptionFailedException,
    UnableToAddSubscriptionItemException,
    UnableToRemoveSubscriptionItemException
};
use Exception;
use Illuminate\Support\Collection;
use Laravel\Cashier\Exceptions\CustomerAlreadyCreated;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Exceptions\SubscriptionUpdateFailure;
use Laravel\Cashier\Invoice;
use LogicException;
use Stripe\{Customer,
    Exception\ApiErrorException,
    PaymentMethod,
    SetupIntent,
    StripeClient,
    Subscription as StripeSubscription,
};
use Symfony\Component\HttpFoundation\Response;

/**
 * Final Class StripeService
 */
final class StripeService extends Provider implements PaymentsInterface
{
    /**
     * createCustomer
     *
     * @param Team|null $team
     *
     * @return Customer
     *
     * @throws CustomerAlreadyCreated
     * @throws CustomerNotLocatedException
     */
    public function createCustomer(?Team $team): Customer
    {
        $owner = $this->getOwner($team);

        return $team?->createAsStripeCustomer([
            'name'        => $team->name,
            'description' => $owner->full_name,
            'email'       => $owner->email,
            'metadata'    => [
                'ENV'      => $this->getMeta(),
                'referral' => $owner->referral,
            ],
        ]);
    }

    /**
     * updateCustomer
     *
     * @param Team|null $team
     * @param array     $attributes
     *
     * @return Customer
     *
     * @throws CustomerNotLocatedException
     */
    public function updateCustomer(?Team $team, array $attributes = []): Customer
    {
        $owner = $this->getOwner($team);

        return $team?->updateStripeCustomer(
            [
                'name'        => $team->name,
                'description' => $owner->full_name,
                'email'       => $owner->email,
            ] + $attributes
        );
    }

    /**
     * Add a Payment Method for the Team to use for a Subscription
     *
     * @param Team|null $team
     * @param string    $pmId
     *
     * @return bool
     *
     * @throws CustomerNotLocatedException
     */
    public function addPaymentMethod(?Team $team, string $pmId = ''): bool
    {
        if ($this->hasSubscription($team)) {
            $this->updateCustomer($team, [
                'invoice_settings' => [
                    'default_payment_method' => $pmId,
                ],
            ]);

            return true;
        }

        return false;
    }

    /**
     * Determine if the current Team has a default/active Payment Method
     *
     * @param Team|null $team
     *
     * @return bool
     */
    public function hasPaymentMethod(?Team $team): bool
    {
        return $team?->hasPaymentMethod();
    }

    /**
     * Fetch and return a list of the Payment Methods the Team has
     *
     * @param Team|null $team
     * @param bool      $default
     *
     * @return ?object
     */
    public function getPaymentMethods(?Team $team, bool $default = false): ?object
    {
        return $team?->paymentMethods()->first();
    }

    /**
     * Increase the amount of the Subscription
     *
     * @param Team|null $team
     * @param int       $amount
     *
     * @return void
     *
     * @throws IncreaseSubscriptionFailedException
     */
    public function increaseSubscription(?Team $team, int $amount = 1): void
    {
        try {
            $team?->subscription()?->incrementQuantity($amount);
        } catch (SubscriptionUpdateFailure $exception) {
            throw new IncreaseSubscriptionFailedException($exception, $team?->id);
        }
    }

    /**
     * Decrease the amount of the Subscription
     *
     * @param Team|null $team
     * @param int       $amount
     *
     * @return void
     *
     * @throws DecreaseSubscriptionFailedException
     */
    public function decreaseSubscription(?Team $team, int $amount = 1): void
    {
        try {
            $team?->subscription()?->decrementQuantity($amount);
        } catch (SubscriptionUpdateFailure $exception) {
            throw new DecreaseSubscriptionFailedException($exception, $team?->id);
        }
    }

    /**
     * Change the amount of the Subscription directly
     *
     * @param Team|null   $team
     * @param string|null $tier
     *
     * @return void
     *
     * @throws AddSubscriptionFailedException
     * @throws ChangeSubscriptionFailedException
     * @throws \Throwable
     */
    public function changeSubscription(?Team $team, string $tier = null): void
    {
        // First of all, let's determine the Tier list array
        // this object consists of the price_key (if different), name and quantity.
        $configuration = $this->tier($tier);

        // If the user currently does not have a subscription on the application
        // We will go ahead and create a new Subscription and attach the correct tier level.
        if ($this->hasSubscription($team) === false) {
            try {
                $subscription = $team
                    ?->newSubscription('default', $configuration->price_id);

                // If the quantity is not null, we will set the quantity
                if ($configuration->quantity !== null) {
                    $subscription->quantity($configuration->quantity);
                }

                // Finally, we will create the subscription
                $subscription->create();
            } catch (IncompletePayment|Exception $exception) {
                terminate(new AddSubscriptionFailedException($exception, $team->id));
            }
        } else {
            // If the team has already got a subscription
            // We will perform a simple Subscription update to change the price key
            try {
                // Get the current subscription and assign to
                // local variable to avoid data interruption.
                $subscription = $team->subscription();

                switch (config('payments.stripe.mode')) {
                    case StripeMode::QUANTITY:
                        // If the StripeMode is set to QUANTITY, we will just update
                        // the quantity level on the subscription
                        $subscription->updateQuantity($configuration->quantity);
                        break;
                    case StripeMode::KEYS:
                        // If the StripeMode is KEYS we will change the subscription
                        // to the correct key for the selected tier.
                        $subscription->swapAndInvoice($configuration->price_id);
                        break;
                }
            } catch (SubscriptionUpdateFailure $exception) {
                terminate(new ChangeSubscriptionFailedException($exception, $team->id));
            }
        }

        // Finally, we will update the subscription_plan_id on the subscription
        $team->subscription()?->update(['subscription_plan_id' => $configuration->id]);

        // And update the tier on the Team
        $team->update(['tier' => $tier]);
    }

    /**
     * Determine if the Team has a current active Subscription
     *
     * @param Team|null $team
     *
     * @return bool
     */
    public function hasSubscription(?Team $team): bool
    {
        $subscription = $team?->subscription();

        if ($subscription === null) {
            return false;
        }

        return $subscription->stripe_status === StripeSubscription::STATUS_ACTIVE;
    }

    /**
     * Return the current active subscription for the Team
     *
     * @param Team|null $team
     *
     * @return Subscription|null
     *
     * @throws NoSubscriptionException
     * @throws \Throwable
     */
    public function getSubscription(?Team $team): ?Subscription
    {
        if (!$this->hasSubscription($team)) {
            terminate(new NoSubscriptionException(null, $team?->id));
        }

        return $team?->subscription();
    }

    /**
     * Cancel the current Subscription for the Team
     *
     * @param Team|null $team
     *
     * @return void
     * @throws NoSubscriptionException
     */
    public function cancelSubscription(?Team $team): void
    {
        if (!$this->hasSubscription($team)) {
            throw new NoSubscriptionException(null, $team?->id);
        }

        $team?->subscription()?->cancel();
    }

    /**
     * Resume the current Subscription for the Team
     *
     * @param Team|null $team
     *
     * @return void
     *
     * @throws ResumeSubscriptionFailedException
     */
    public function resumeSubscription(?Team $team): void
    {
        try {
            $team?->subscription()?->resume();
        } catch (LogicException $exception) {
            throw new ResumeSubscriptionFailedException($team?->id, $exception);
        }
    }

    /**
     * generatePaymentToken
     *
     * @param Team|null $team
     *
     * @return SetupIntent
     */
    public function generatePaymentToken(?Team $team): SetupIntent
    {
        return $team?->createSetupIntent([
            'customer' => $team->stripe_id,
        ]);
    }

    /**
     * Retrieves all invoices for Team
     *
     * @param Team|null $team
     *
     * @return Collection|Invoice
     */
    public function getInvoices(?Team $team): Collection|array
    {
        return $team->invoicesIncludingPending();
    }

    /**
     * Retrieves all invoices for Team
     *
     * @param Team|null   $team
     * @param string|null $id
     *
     * @return Response
     */
    public function downloadInvoice(?Team $team, string $id = null): Response
    {
        return $team->downloadInvoice(
            id: $id,
            data: [],
            filename: env('APP_URL') . now()->format('Y-m-d')
        );
    }
}
