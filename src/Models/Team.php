<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Events\TeamCreated;
use RedRockDigital\Api\Models\Pivot\TeamUser;
use RedRockDigital\Api\Services\Payments\Payments;
use RedRockDigital\Api\Traits\HasInformable;
use RedRockDigital\Api\Traits\HasUuid;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    BelongsToMany
};
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
};
use Illuminate\Database\Query\Builder;
use Illuminate\Support\{
    Carbon,
    Collection
};
use Laravel\Cashier\Billable;

/**
 * RedRockDigital\Api\Models\Team
 *
 * @property string                         $id
 * @property string|null                    $owner_id
 * @property string                         $name
 * @property string|null                    $tier
 * @property string|null                    $friendly_tier_name
 * @property bool                           $has_onboarded
 * @property array|null                     $features
 * @property string|null                    $billing_information
 * @property Carbon|null                    $created_at
 * @property Carbon|null                    $updated_at
 * @property string|null                    $stripe_id
 * @property string|null                    $pm_type
 * @property string|null                    $pm_last_four
 * @property string|null                    $trial_ends_at
 * @property bool                           $payment_failed
 * @property array                          $allowances
 * @property-read User|null                 $owner
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null                  $subscriptions_count
 * @property-read Collection|User[]         $users
 * @property-read int|null                  $users_count
 *
 * @method static TeamFactory factory(...$parameters)
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereBillingInformation($value)
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereOwnerId($value)
 * @method static Builder|Team wherePmLastFour($value)
 * @method static Builder|Team wherePmType($value)
 * @method static Builder|Team whereStripeId($value)
 * @method static Builder|Team whereTier($value)
 * @method static Builder|Team whereTrialEndsAt($value)
 * @method static Builder|Team whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Team extends Model
{
    use HasFactory;
    use HasUuid;
    use Billable;
    use HasInformable;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'ref',
        'billing_information',
        'owner_id',
        'has_onboarded',
        'tier',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'features',
        'allowances',
        'payment_failed',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'has_onboarded' => 'boolean',
        'features'      => 'array',
        'allowances'    => 'array',
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TeamUser::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all the subscriptions for the Stripe model.
     *
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, $this->getForeignKey())->orderBy('created_at', 'desc');
    }

    /**
     * Get a subscription instance by name.
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection
     *
     * @param string $name
     *
     * @return ?Subscription
     */
    public function subscription($name = 'default'): ?Subscription
    {
        return $this->subscriptions->where('name', $name)->first();
    }

    /**
     * Returns the friendly name of the subscription tier.
     *
     * @return string
     */
    public function getFriendlyTierNameAttribute(): string
    {
        return config(sprintf("payments.%s.tiers.%s.name",
            Payments::getProvider(),
            $this->tier
        ));
    }
}
