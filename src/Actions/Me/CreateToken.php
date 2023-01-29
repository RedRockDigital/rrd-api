<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\User;

class CreateToken
{
    /**
     * @param  User  $user
     * @param  string  $name
     * @param  string  $expiration
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function __invoke(User $user, string $name, string $expiration)
    {
        $token = $user->createToken($name, []);

        [$count, $unit] = explode('-', $expiration);

        $token->token->update([
            'expires_at' => now()->add($unit, $count),
        ]);

        return $token;
    }
}
