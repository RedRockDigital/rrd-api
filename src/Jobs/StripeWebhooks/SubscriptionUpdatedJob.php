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
            // Get the up-coming invoice
            // This will be used to get the next payment amount
            /** @var Invoice $subscription */ $upcomingInvoice = $this->team->subscription()->upcomingInvoice();

            // Update the subscription
            // This will update the next payment date and amount
            // This will also update the price
            $this->team->subscription()->update([
                'next_payment_amount' => ($upcomingInvoice?->rawAmountDue() / 100),
                'next_payment_date'   => Arr::get($this->webhook->payload, 'object.current_period_end'),
                'price'               => (double)(Arr::get($this->webhook->payload, 'object.plan.amount') / 100)
            ]);

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
