<?php

namespace RedRockDigital\Api\Nova\Metrics;

use RedRockDigital\Api\Models\Subscription;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;
use Stripe\Subscription as StripeSubscription;

/**
 * Final Class CancelledSubscriptions
 */
final class CancelledSubscriptions extends Value
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
            Subscription::whereStripeStatus(StripeSubscription::STATUS_CANCELED)->where([
                ['updated_at', '>=', now()->startOfMonth()],
                ['updated_at', '<=', now()->endOfMonth()],
            ])->count()
        );
    }
}
