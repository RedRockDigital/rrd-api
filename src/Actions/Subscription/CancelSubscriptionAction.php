<?php

namespace App\Actions\Subscription;

use App\Models\Team;
use App\Services\Payments\Payments;

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
