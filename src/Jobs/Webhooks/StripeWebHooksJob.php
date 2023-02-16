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

    /** @var string  */
    private string $customerId;

    /** @var Team  */
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
            'invoice.payment_failed' => $this->handleInvoicePaymentFailed(),
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
        $this->team->update(['payment_failed' => true]);

        // TODO: Send email to user asking them to update their details.

        // Finally update the webhook
        $this->webhook->update([
            'status'   => 'completed',
            'response' => [
                'message' => "Customer ID ($this->customerId) on Team ({$this->team->id}) payments failed successfully flagged.",
            ],
        ]);
    }

    /**
     * This method handles when a Subscription has been updated
     *
     * @return void
     */
    private function handleSubscriptionUpdated(): void
    {
        // If the subscription is cancelled at the end of the period
        // We need to update the subscription to cancelled
        // This is because Stripe will not send a subscription cancelled
        if (Arr::get($this->webhook->payload, 'object.cancel_at_period_end') !== null) {
            $team->subscription()->update([
                'stripe_status' => StripeStatus::CANCELLED,
            ]);

            return;
        }

        // If the subscription is not cancelled at the end of the period
        // We will update the subscription with the new details and treat it as a normal update

        /** @var Invoice $subscription */
        $upcomingInvoice = $this->team->subscription()->upcomingInvoice();

        // Update the subscription
        $this->team->subscription()->update([
            'price'               => floatval(Arr::get($this->webhook->payload, 'object.plan.amount') / 100),
            'next_payment_date'   => Arr::get($this->webhook->payload, 'object.current_period_end'),
            'next_payment_amount' => ($upcomingInvoice?->rawAmountDue() / 100)
        ]);

        // Finally update the webhook
        $this->webhook->update([
            'status'   => 'completed',
            'response' => [
                'message' => "Customer ID ($this->customerId) on Team ({$this->team->id}) subscription has been updated.",
            ],
        ]);
    }

    /**
     * This method handles when a Subscription has been cancelled
     *
     * @return void
     */
    private function handleSubscriptionDeleted(): void
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
     * This method locates the Customer ID and
     * team from the in-coming webhook request
     *
     * @return array
     */
    private function locateTeamFromCustomerId(): void
    {
        // Grab the Customer ID from the payload,
        // If we return as null ID, we will stop the command and log.
        if (($this->customerId = Arr::get($this->webhook->payload, 'object.customer')) === null) {
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
        if (($this->team = Team::whereStripeId($customerId)->first()) === null) {
            $this->webhook->update([
                'status'   => 'failed',
                'response' => [
                    'message' => "Customer ID ($customerId) was not found on Team",
                ],
            ]);
            exit;
        }
    }
}
