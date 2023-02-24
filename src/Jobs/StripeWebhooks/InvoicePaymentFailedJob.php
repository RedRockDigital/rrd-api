<?php

namespace RedRockDigital\Api\Jobs\StripeWebhooks;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Invoice;
use RedRockDigital\Api\Mail\Stripe\PaymentFailed;
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
 * Final Class InvoicePaymentFailedJob
 */
final class InvoicePaymentFailedJob extends StripeWebhookJob implements ShouldQueue
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
            // Flag the team as payment failed
            // This will allow frontend to notify the user to update their details
            $this->team->update(['payment_failed' => true]);
            $this->team->subscription()->update(['stripe_status' => StripeStatus::PAST_DUE->value]);
            
            // Send an email to the team owner
            // This will allow the team owner to update their details
            Mail::to($email = $this->team->owner->email)->send(new PaymentFailed(
                name: $this->team->owner->first_name,
                email: $email,
                body: "Payment failed for team {$this->team->name}."
            ));

            // Set the response
            $this->webhook->setTeamResponse($this->team->id, "payments failed successfully flagged.");
        } catch (\Exception $e) {
            // Set the webhook to failed
            // And set the response
            $this->webhook->markAsFailed($e->getMessage());
        }
    }
}
