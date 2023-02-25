<?php

namespace RedRockDigital\Api\Jobs\StripeWebhooks;

use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Invoice;
use RedRockDigital\Api\Models\Webhook;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{
    InteractsWithQueue,
    SerializesModels
};
use Illuminate\Support\Arr;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\Enums\StripeStatus;

/**
 * Final Class SubscriptionUpdatedJob
 */
final class SubscriptionUpdatedJob extends StripeWebhookJob implements ShouldQueue
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
    public function __construct(public readonly Webhook $webhook)
    {
        parent::__construct();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            // Grab the payload from the webhook
            $payload = $this->webhook->payload;
            $stripeStatus = StripeStatus::tryFrom(Arr::get($payload, 'object.status'));

            // If the status is past due, this is most likely a failed payment
            // Which will be handled on the InvoicePaymentFailedJob
            // So we can just return here
            if ($stripeStatus === StripeStatus::PAST_DUE) {
                $this->webhook->setTeamResponse($this->team->id, "subscription is past due, so we will not update it.");
                return;
            }

            // Get the up-coming invoice
            // This will be used to get the next payment amount
            /** @var Invoice $subscription */
            $upcomingInvoice = $this->team->subscription()->upcomingInvoice();

            // Update the subscription
            // This will update the next payment date and amount
            // This will also update the price
            $this->team->subscription()->update([
                'next_payment_amount' => ($upcomingInvoice?->rawAmountDue() / 100),
                'next_payment_date'   => Arr::get($this->webhook->payload, 'object.current_period_end'),
                'price'               => (double)(Arr::get($this->webhook->payload, 'object.plan.amount') / 100),
                'stripe_status'       => $stripeStatus
            ]);

            // The team has now paid
            // So we can flag the team as not payment failed, if previously flagged
            if ($stripeStatus === StripeStatus::ACTIVE &&! $this->team->payment_failed) {
                $this->team->update(['payment_failed' => false]);
            }

            // Set the webhook to completed
            // And set the response
            $this->webhook->setTeamResponse($this->team->id, "subscription has been updated.");
        } catch (\Exception $e) {
            // Set the webhook to failed
            // And set the response
            $this->webhook->markAsFailed($e->getMessage());
        }
    }
}
