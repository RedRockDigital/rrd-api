<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Cashier\SubscriptionItem;

/**
 * App\Models\Subscription
 *
 * @property int                                $id
 * @property string                             $team_id
 * @property string                             $name
 * @property float                              $price
 * @property string                             $stripe_id
 * @property string                             $stripe_status
 * @property string|null                        $stripe_plan
 * @property string|null                        $stripe_price
 * @property array|null                         $context
 * @property int|null                           $quantity
 * @property Carbon|null                        $trial_ends_at
 * @property Carbon|null                        $ends_at
 * @property Carbon|null                        $next_payment_date
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Collection|SubscriptionItem[] $items
 * @property-read int|null                      $items_count
 * @property-read Team                          $owner
 * @property-read Team                          $user
 *
 * @method static Builder|Subscription active()
 * @method static Builder|Subscription cancelled()
 * @method static Builder|Subscription ended()
 * @method static Builder|Subscription incomplete()
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription notCancelled()
 * @method static Builder|Subscription notOnGracePeriod()
 * @method static Builder|Subscription notOnTrial()
 * @method static Builder|Subscription onGracePeriod()
 * @method static Builder|Subscription onTrial()
 * @method static Builder|Subscription pastDue()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription recurring()
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereEndsAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereName($value)
 * @method static Builder|Subscription whereTeamId($value)
 * @method static Builder|Subscription whereQuantity($value)
 * @method static Builder|Subscription whereStripeId($value)
 * @method static Builder|Subscription whereStripePlan($value)
 * @method static Builder|Subscription whereStripeStatus($value)
 * @method static Builder|Subscription whereTrialEndsAt($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class Subscription extends \Laravel\Cashier\Subscription
{
    protected $casts = [
        'price'             => 'float',
        'quantity'          => 'integer',
        'next_payment_date' => 'date',
    ];

    /**
     * Get the model related to the subscription.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        $model = config('cashier.model');

        return $this->belongsTo($model, (new $model())->getForeignKey())->withoutGlobalScopes();
    }
}
