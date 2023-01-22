<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\User;

class CreateRecoveryCodes
{
    /**
     * @param  User  $user
     * @return string
     */
    public function __invoke(User $user): User
    {
        $codes = $user->generateRecoveryCodes();

        $user->forceFill([
            'two_factor_recovery_codes' => $codes,
        ])->save();

        return $codes;
    }
}
