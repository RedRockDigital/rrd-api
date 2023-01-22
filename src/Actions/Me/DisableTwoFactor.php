<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\User;

class DisableTwoFactor
{
    /**
     * @param  User  $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        $user->forceFill([
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_verified_at'    => null,
        ])->save();

        return $user;
    }
}
