<?php

namespace App\Services\Payments\Providers;

use App\Models\Team;
use App\Models\User;
use App\Services\Payments\PaymentsInterface;
use App\Services\Payments\Providers\Stripe\Exceptions\CustomerNotLocatedException;

/**
 * Class Providers
 */
abstract class Provider implements PaymentsInterface
{
    /**
     * Determine in a friendly name the provider.
     *
     * @param  string|null  $provider
     * @return string|bool
     */
    public static function getProvider(string $provider = null): string|bool
    {
        $active = config(sprintf('payments.providers.%s', config('payments.provider')));

        if ($provider === null) {
            return $active;
        }

        return $provider === $active;
    }

    /**
     * @param  Team|null  $team
     * @return array|null
     */
    public function getAllowances(?Team $team): ?array
    {
        return config(
            sprintf(
                'payments.%s.tiers.%s.allowances',
                self::getProvider(),
                $team->tier
            )
        );
    }

    /**
     * Get the User of the Team who owns the subscription
     *
     * @param  Team|null  $team
     * @return User
     *
     * @throws CustomerNotLocatedException
     */
    public function getOwner(?Team $team): User
    {
        /** @var User $owner */
        $owner = $team?->owner()->first();

        if ($owner === null) {
            throw new CustomerNotLocatedException();
        }

        return $owner;
    }

    /**
     * @return string
     */
    public function getEnvMeta(): string
    {
        if (app()->environment(['local'])) {
            return env('APP_ENV').'_'.env('APP_AUTHOR');
        }

        return env('APP_ENV');
    }
}
