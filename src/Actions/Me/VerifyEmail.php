<?php

namespace App\Actions\Me;

use App\Models\User;

class VerifyEmail
{
    /**
     * @param  string  $userId
     * @param  ?string  $firstName
     * @param  ?string  $lastName
     * @param  ?string  $password
     * @return User
     */
    public function __invoke(string $userId, ?string $firstName, ?string $lastName, ?string $password): User
    {
        $user = User::findOrFail($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        if (!$user->is_setup) {
            $user->update([
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'password'   => $password,
            ]);
        }

        return $user;
    }
}
