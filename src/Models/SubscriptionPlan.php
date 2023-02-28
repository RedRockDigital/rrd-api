<?php

/** @noinspection PhpMissingFieldTypeInspection */

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
        'stripe_product_id',
        'price',
        'stripe_price_id',
    ];

    /**
     * Get the subscription per plan.
     *
     * @param  string  $value
     * @return float
     */
    public function subscriptions(): Subscription
    {
        return $this->hasMany(Subscription::class);
    }
}