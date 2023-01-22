<?php

namespace RedRockDigital\Api\Nova\Metrics;

use RedRockDigital\Api\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

/**
 * Final Class NewUsers
 */
final class NewUsers extends Value
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
            User::where([
                ['created_at', '>=', now()->subDay()],
            ])->count()
        );
    }
}
