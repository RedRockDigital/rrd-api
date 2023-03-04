<?php

namespace RedRockDigital\Api\Services\Payments\Providers;

use RedRockDigital\Api\Models\SubscriptionPlan;
use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use RedRockDigital\Api\Services\Payments\PaymentsInterface;
use RedRockDigital\Api\Services\Payments\Providers\Stripe\Exceptions\CustomerNotLocatedException;

/**
 * Class Provider
 *
 * @package RedRockDigital\Api\Services\Payments\Providers
 */
abstract class Provider
{
    /**
     * Get the tier config for the provider.
     *
     * @param Team|null $team
     *
     * @return User
     */
    public function tier(string $name): SubscriptionPlan
    {
        // Get the tier from the database.
        return SubscriptionPlan::whereStatic($name)->firstOrFail();
    }

    /**
     * Determine in a friendly name the provider.
     *
     * @param string|null $provider
     *
     * @return string|bool
     */
    public static function provider(string $provider = null): string|bool
    {
        // Get the active provider.
        $active = config(sprintf('payments.providers.%s', config('payments.provider')));

        // If we don't have a provider, return the active provider.
        if ($provider === null) {
            return $active;
        }

        // Otherwise, return if the provider is the same as the active provider.
        return $provider === $active;
    }

    /**
     * @param Team|null $team
     *
     * @return array|null
     */
    public function getAllowances(?Team $team): ?array
    {
        // Get the allowances for the team from the config for their tier.
        return config(
            sprintf('payments.%s.tiers.%s.allowances', self::provider(), $team->tier)
        );
    }

    /**
     * Get the User of the Team who owns the subscription
     *
     * @param Team|null $team
     *
     * @return User
     *
     * @throws CustomerNotLocatedException
     */
    public function getOwner(?Team $team): User
    {
        /** @var User $owner */
        $owner = $team?->owner()->first();

        // If we can't find the owner, throw an exception.
        if ($owner === null) {
            throw new CustomerNotLocatedException();
        }

        // Otherwise, return the owner.
        return $owner;
    }

    /**
     * Get the meta data for the subscription.
     *
     * @return string
     */
    public function getMeta(): string
    {
        // If we're in local, we want to add the author to the meta data.
        if (app()->environment(['local'])) {
            return env('APP_ENV') . '_' . env('APP_AUTHOR');
        }

        // Otherwise, just return the environment.
        return env('APP_ENV');
    }
}
