<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\PasswordReset;

class ResetPassword
{
    /**
     * @param  string  $token
     * @param  string  $username
     * @param  string  $password
     * @return void
     */
    public function __invoke(string $token, string $username, string $password): void
    {
        $passwordReset = PasswordReset::where([
            'token'                      => $token,
            config('base.auth.username') => $username,
        ])->firstOrFail();

        $passwordReset->user->update([
            'password' => $password,
        ]);

        $passwordReset->delete();
    }
}
