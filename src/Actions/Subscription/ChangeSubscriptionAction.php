<?php

namespace App\Actions\Subscription;

use App\Models\Team;
use App\Services\Payments\Payments;

/**
 * Final ChangeSubscriptionAction
 */
final class ChangeSubscriptionAction
{
    /**
     * @param  string|null  $tier
     * @param  int  $tierAmount
     * @param  Team|null  $team
     * @return void
     */
    public function __invoke(string $tier = null, int $tierAmount = 1, Team $team = null): void
    {
        Payments::changeSubscription(
            team: $team = $team ?? team(),
            tier: $tier
        );

        $team->updateQuietly(['tier' => $tier]);
    }
}
