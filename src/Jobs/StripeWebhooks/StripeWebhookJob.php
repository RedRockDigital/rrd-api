<?php

namespace RedRockDigital\Api\Jobs\StripeWebhooks;

use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Invoice;
use RedRockDigital\Api\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{
    InteractsWithQueue,
    SerializesModels
};
use Illuminate\Support\Arr;

/**
 * Final Class StripeWebhookJob
 */
abstract class StripeWebhookJob
{
    /** @var Team  */
    public Team $team;

    /**
     * This method locates the Customer ID and
     * team from the in-coming webhook request
     *
     * @return array
     */
    public function __construct()
    {
        // Grab the Customer ID from the payload,
        // If we return as null ID, we will stop the command and log.
        if (($this->customerId = Arr::get($this->webhook->payload, 'object.customer')) === null) {
            $this->webhook->markAsFailed('Customer ID from payload was NULL');
            exit;
        }

        // We will now try and look-up the Customer ID on the Team Model
        // If we cannot find out, we will stop and log
        if (($this->team = Team::whereStripeId($this->customerId)->first()) === null) {
            $this->webhook->markAsFailed("Customer ID ($this->customerId) was not found on Team");
            exit;
        }
    }
}
