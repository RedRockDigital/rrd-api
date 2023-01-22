<?php

namespace App\Jobs\Webhooks;

use App\Models\Team;
use App\Models\Webhook;
use App\Services\Payments\Payments;
use App\Services\Payments\Providers\Stripe\Enums\StripeStatus;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly Webhook $webhook)
    {
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
            default                         => $this->handleHookNotFound()
        };
    }

    /**
     * This method handles the Payment Failed from an up-coming
     * invoice
     *
     * @return void
     */
    protected function handleInvoicePaymentFailed(): void
    {
        // Try and locate the Team from the CustomerId
        [$customerId, $team] = $this->locateTeamFromCustomerId();

        // We will flag that the Team has a recent failed payment.
        $team->update(['payment_failed' => true]);

        //TODO: Send email to user asking them to update their details.

        // Finally update the webhook
        $this->webhook->update([
            'status'   => 'completed',
            'response' => [
                'message' => "Customer ID ($customerId) on Team ($team->id) payments failed successfully flagged.",
            ],
        ]);
    }

    /**
     * This method handles when a Subscription has been updated
     *
     * @return void
     */
    protected function handleSubscriptionUpdated(): void
    {
        // Try and locate the Team from the CustomerId
        /** @var Team $team */
        [$customerId, $team] = $this->locateTeamFromCustomerId();

        // Update the subscription with the next payment date
        $team->subscription()->update([
            'price'             => floatval(Arr::get($this->webhook->payload, 'object.plan.amount') / 100),
            'next_payment_date' => Arr::get($this->webhook->payload, 'object.current_period_end'),
        ]);

        // Finally update the webhook
        $this->webhook->update([
            'status'   => 'completed',
            'response' => [
                'message' => "Customer ID ($customerId) on Team ($team->id) subscription has been updated.",
            ],
        ]);
    }

    /**
     * This method handles when a Subscription has been cancelled
     *
     * @return void
     */
    protected function handleSubscriptionDeleted(): void
    {
        // Try and locate the Team from the CustomerId
        /** @var Team $team */
        [$customerId, $team] = $this->locateTeamFromCustomerId();

        // Grab the FREE tier from our config.
        $config = config(
            sprintf('payments.%s.tiers.%s', Payments::getProvider(), 'FREE')
        );

        // We will downgrade their subscription down to the free tier
        $team->update(['tier' => 'FREE']);

        // Then we will update their subscription, based on the FREE Tier
        // We cannot do this via the API, as the subscription is now cancelled.
        $team->subscription()->update([
            'price'         => 0,
            'stripe_price'  => $config['key'],
            'stripe_status' => StripeStatus::CANCELLED->name,
            'ends_at'       => Arr::get($this->webhook->payload, 'object.ended_at'),
        ]);

        // Finally update the webhook
        $this->webhook->update([
            'status'   => 'completed',
            'response' => [
                'message' => "Customer ID ($customerId) on Team ($team->id) subscription as been cancelled successfully.",
            ],
        ]);
    }

    /**
     * This method handles when an in-coming hook has
     * not been found
     *
     * @return void
     */
    protected function handleHookNotFound(): void
    {
        $this->webhook->update([
            'status'   => 'failed',
            'response' => [
                "No matching hook was found ({$this->webhook->hook})",
            ],
        ]);
    }

    /**
     * This method locates the Customer ID and
     * team from the in-coming webhook request
     *
     * @return array
     */
    private function locateTeamFromCustomerId(): array
    {
        // Grab the Customer ID from the payload,
        // If we return as null ID, we will stop the command and log.
        if (($customerId = Arr::get($this->webhook->payload, 'object.customer')) === null) {
            $this->webhook->update([
                'status'   => 'failed',
                'response' => [
                    'message' => 'Customer ID from payload was NULL',
                ],
            ]);
            exit;
        }

        // We will now try and look-up the Customer ID on the Team Model
        // If we cannot find out, we will stop and log
        if (($team = Team::whereStripeId($customerId)->first()) === null) {
            $this->webhook->update([
                'status'   => 'failed',
                'response' => [
                    'message' => "Customer ID ($customerId) was not found on Team",
                ],
            ]);
            exit;
        }

        return [$customerId, $team];
    }
}
