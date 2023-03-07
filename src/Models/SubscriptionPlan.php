<?php

namespace RedRockDigital\Api\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Cashier\SubscriptionItem;
use RedRockDigital\Api\Traits\HasUuid;

/**
 * RedRockDigital\Api\Models\Subscription
 *
 * @property string                         $id
 * @property string                         $name
 * @property string                         $static
 * @property string                         $product_id
 * @property string                         $price_id
 * @property float                          $price
 * @property integer                        $quantity
 * @property Carbon|null                    $created_at
 * @property Carbon|null                    $updated_at
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null                  $subscriptions_count
 * @method static Builder|SubscriptionPlan newModelQuery()
 * @method static Builder|SubscriptionPlan newQuery()
 * @method static Builder|SubscriptionPlan query()
 * @method static Builder|SubscriptionPlan whereCreatedAt($value)
 * @method static Builder|SubscriptionPlan whereId($value)
 * @method static Builder|SubscriptionPlan whereName($value)
 * @method static Builder|SubscriptionPlan wherePrice($value)
 * @method static Builder|SubscriptionPlan whereProductId($value)
 * @method static Builder|SubscriptionPlan wherePriceId($value)
 * @method static Builder|SubscriptionPlan whereStatic($value)
 * @method static Builder|SubscriptionPlan whereUpdatedAt($value)
 * @method static Builder|SubscriptionPlan whereQuanity($value)
 * @mixin Eloquent
 */
final class SubscriptionPlan extends Model
{
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'static',
        'product_id',
        'price',
        'quanity',
        'price_id',
    ];

    /**
     * Get the subscription per plan.
     *
     * @param string $value
     *
     * @return float
     */
    public function subscriptions(): Subscription
    {
        return $this->hasMany(Subscription::class);
    }
}