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
 * Final Class SubscriptionDeletedJob
 */
final class SubscriptionDeletedJob extends StripeWebhookJob implements ShouldQueue
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
            // Set their teir to null
            // As they have no active subscription on Stripe.
            $team->update(['tier' => null]);

            // As the subscription has been deleted from Stripe
            // We will now delete the subscription from the database
            // This will also delete the subscription items
            $this->team->subscription()->items()->delete();
            $this->team->subscription()->delete();

            // Set the webhook to completed
            $this->webhook->setTeamResponse($this->team->id, "subscription has been cancelled.");
        } catch (\Exception $e) {
            // Set the webhook to failed
            // And set the response
            $this->webhook->markAsFailed($e->getMessage());
        }
    }
}
