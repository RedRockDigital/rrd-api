<?php

namespace RedRockDigital\Api\Observers;

use RedRockDigital\Api\Jobs\StripeWebhooks\SubscriptionUpdated;
use RedRockDigital\Api\Jobs\Webhooks\StripeWebHooksJob;
use RedRockDigital\Api\Models\Webhook;

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
        // Fetch the config for the webhooks
        // This will be an array of hooks and their Jobs per provider
        /** @var arrary $webhooks */
        $webhooks = config("webhooks.{$webhook->provider}");

        // If the config is empty
        if ($webhooks === null) {
            return;
        }

        // If the webhooks is in the config
        // This will be used to match the in-coming hook to the method
        if (array_key_exists($webhook->event, $webhooks)) {
            // Off-load to the method and continue the logic.
            $webhooks[$webhook->event]::dispatch($webhook);
        }
    }
}
