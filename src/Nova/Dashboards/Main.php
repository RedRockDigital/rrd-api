<?php

namespace RedRockDigital\Api\Nova\Dashboards;

use RedRockDigital\Api\Nova\Metrics\{
    ActiveSubscriptions,
    CancelledSubscriptions,
    NewTeams,
    NewUsers,
    TeamsPerDay,
    UsersPerDay
};
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards(): array
    {
        return [
            (new UsersPerDay())->width('1/2'),
            (new NewUsers())->width('1/4'),
            (new ActiveSubscriptions())->width('1/4'),
            (new NewTeams())->width('1/4'),
            (new TeamsPerDay())->width('1/2'),
            (new CancelledSubscriptions())->width('1/4'),
        ];
    }
}
