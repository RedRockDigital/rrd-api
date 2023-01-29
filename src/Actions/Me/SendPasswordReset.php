<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\PasswordReset;
use RedRockDigital\Api\Models\User;
use RedRockDigital\Api\Notifications\PasswordResetNotification;

class SendPasswordReset
{
    /**
     * @param  string  $username
     * @return void
     */
    public function __invoke(string $username): void
    {
        /*** @var User $user */
        $user = User::where([
            config('base.auth.username') => $username,
        ])->first();

        if ($user) {
            /*** @var PasswordReset $passwordReset */
            $passwordReset = PasswordReset::create([
                'user_id'                    => $user->id,
                config('base.auth.username') => $username,
            ]);

            $user->notify(new PasswordResetNotification($passwordReset));
        }
    }
}
