<?php

namespace RedRockDigital\Api\Actions\Subscription;

use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Services\Payments\Payments;

/**
 * Final CancelSubscriptionAction
 */
final class CancelSubscriptionAction
{
    /**
     * @param  Team|null  $team
     * @return void
     */
    public function __invoke(Team $team = null): void
    {
        $team = $team ?? team();

        Payments::cancelSubscription($team);

        $team->updateQuietly([
            'tier' => null,
        ]);
    }
}
