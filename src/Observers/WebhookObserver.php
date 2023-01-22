<?php

namespace App\Observers;

use App\Jobs\Webhooks\StripeWebHooksJob;
use App\Models\Webhook;

/**
 * Final Class WebhookObserver
 */
final class WebhookObserver
{
    /**
     * Handle the Webhook "created" event.
     *
     * @param Webhook $webhook
     * @return void
     */
    public function created(Webhook $webhook): void
    {
        match ($webhook->originator) {
            'stripe' => StripeWebHooksJob::dispatch($webhook)
        };
    }
}
