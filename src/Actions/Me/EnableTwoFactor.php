<?php

namespace App\Actions\Me;

use App\Models\User;

class EnableTwoFactor
{
    /**
     * @param  User  $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        $google2fa = app('pragmarx.google2fa');

        $user->forceFill([
            'two_factor_secret'         => $google2fa->generateSecretKey(),
            'two_factor_recovery_codes' => $user->generateRecoveryCodes(),
            'two_factor_verified_at'    => now(),
        ])->save();

        return $user;
    }
}
