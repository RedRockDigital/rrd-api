<?php

namespace RedRockDigital\Api\Http\Controllers\Password;

use RedRockDigital\Api\Actions\Me\ResetPassword;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Password\PasswordResetRequest;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'reset-password' => false,
    ];

    /**
     * @param  ResetPassword  $resetPassword
     * @param  PasswordResetRequest  $request
     * @return JsonResponse
     */
    public function update(ResetPassword $resetPassword, PasswordResetRequest $request): JsonResponse
    {
        $resetPassword(
            token: $request->get('token'),
            username: $request->get(config('base.auth.username')),
            password: $request->get('password'),
        );

        return $this->response->setStatusCode(200);
    }
}
