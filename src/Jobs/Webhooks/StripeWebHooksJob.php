<?php

namespace RedRockDigital\Api\Jobs\Webhooks;

use Laravel\Cashier\Invoice;
use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\Webhook;
use RedRockDigital\Api\Services\Payments\Payments;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\Enums\StripeStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\{ShouldQueue};
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{
    InteractsWithQueue,
    SerializesModels
};
use Illuminate\Support\Arr;

/**
 * Final Class StripeWebHooksJob
 */
final class StripeWebHooksJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var string */
    private string $customerId;

    /** @var Team */
    private Team $team;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly Webhook $webhook)
    {
        // Try and locate the Team from the CustomerId
        $this->locateTeamFromCustomerId();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // If the request check is completed
        // Set the webhook to processing
        $this->webhook->update(['status' => 'processing']);

        // Match the in-coming hook to the method
        // Off-load to the method and continue the logic.
        match ($this->webhook->hook) {
            'invoice.payment_failed'        => $this->handleInvoicePaymentFailed(),
            'customer.subscription.updated',
            'customer.subscription.created' => $this->handleSubscriptionUpdated(),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted(),
            default => null
        };
    }

    /**
     * This method handles the Payment Failed from an up-coming
     * invoice
     *
     * @return void
     */
    private function handleInvoicePaymentFailed(): void
    {
        // Flag the team as payment failed
        // This will allow frontend to notify the user to update their details
        $this->team->update(['payment_failed' => true]);

        // TODO: Send email to user asking them to update their details.

        // Set the response
        $this->webhook->setResponse($this->customerId, $this->team->id, "payments failed successfully flagged.");
    }

    /**
     * This method handles when a Subscription has been updated
     *
     * @return void
     */
    private function handleSubscriptionUpdated(): void
    {
        // Get the up-coming invoice
        // This will be used to get the next payment amount
        /** @var Invoice $subscription */ $upcomingInvoice = $this->team->subscription()->upcomingInvoice();

        // Update the subscription
        // This will update the next payment date and amount
        // This will also update the price
        $this->team->subscription()->update([
            'next_payment_amount' => ($upcomingInvoice?->rawAmountDue() / 100),
            'next_payment_date'   => Arr::get($this->webhook->payload, 'object.current_period_end'),
            'price'               => floatval(Arr::get($this->webhook->payload, 'object.plan.amount') / 100),
        ]);

        // Set the webhook to completed
        // And set the response
        $this->webhook->setResponse($this->customerId, $this->team->id, "subscription has been updated.");
    }

    /**
     * This method handles when a Subscription has been cancelled
     *
     * @return void
     */
    private function handleSubscriptionDeleted(): void
    {
        // Set their teir to null
        // As they have no active subscription on Stripe.
        $team->update(['tier' => null]);

        // As the subscription has been deleted from Stripe
        // We will now delete the subscription from the database
        // This will also delete the subscription items
        $this->team->subscription()->items()->delete();
        $this->team->subscription()->delete();

        // Set the webhook to completed
        $this->webhook->setResponse($this->customerId, $this->team->id, "subscription has been cancelled.");
    }

    
}
