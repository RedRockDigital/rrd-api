<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\User;

class VerifyTwoFactor
{
    /**
     * @param  User  $user
     * @param  string  $code
     * @return bool
     */
    public function __invoke(User $user, string $code): bool
    {
        // Check OTP
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->two_factor_secret, $code);

        if ($valid) {
            return $this->verified($user);
        }

        // Check recovery code
        if (in_array($code, $user->recoveryCodes())) {
            return $this->verified($user);
        }

        return false;
    }

    /**
     * @param  User  $user
     * @return bool
     */
    private function verified(User $user): bool
    {
        return $user->forceFill([
            'two_factor_verified_at' => now(),
        ])->save();
    }
}
