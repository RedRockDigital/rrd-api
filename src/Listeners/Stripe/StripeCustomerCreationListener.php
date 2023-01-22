<?php

namespace RedRockDigital\Api\Listeners\Stripe;

use RedRockDigital\Api\Events\TeamCreated;
use RedRockDigital\Api\Services\Payments\Payments;

final class StripeCustomerCreationListener
{
    /**
     * Handle the event.
     *
     * @param  TeamCreated  $event
     * @return void
     */
    public function handle(TeamCreated $event): void
    {
        Payments::createCustomer($event->team);

        if (array_key_exists('FREE', config(sprintf('payments.%s.tiers', Payments::getProvider())))) {
            Payments::changeSubscription($event->team, 'FREE');

            $event->team->update([
                'allowances' => Payments::getAllowances($event->team),
            ]);
        }
    }
}
