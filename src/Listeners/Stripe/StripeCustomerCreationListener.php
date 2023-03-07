<?php

namespace RedRockDigital\Api\Listeners\Stripe;

use RedRockDigital\Api\Events\TeamCreated;
use RedRockDigital\Api\Models\SubscriptionPlan;
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
        // Create the customer in Stripe.
        Payments::createCustomer($event->team);

        // If the FREE tier is not in the config, return.
        if (($plan = SubscriptionPlan::whereStatic('FREE')->first()) === null) {
            return;
        }

        // Change the subscription to the FREE tier.
        Payments::changeSubscription($event->team, $plan->static);

        // Update the team's allowances.
        $event->team->update([
            'allowances' => Payments::getAllowances($event->team),
        ]);
    }
}
