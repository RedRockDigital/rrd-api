<?php

namespace App\Listeners\Stripe;

use App\Events\TeamCreated;
use App\Services\Payments\Payments;

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
