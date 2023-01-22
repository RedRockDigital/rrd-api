<?php

namespace App\Nova\Metrics;

use App\Models\Team;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

/**
 * Final Class NewTeams
 */
final class NewTeams extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  NovaRequest  $request
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->result(
            Team::where([
                ['created_at', '>=', now()->subDay()],
            ])->count()
        );
    }
}
