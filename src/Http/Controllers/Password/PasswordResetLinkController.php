<?php

namespace RedRockDigital\Api\Http\Controllers\Password;

use RedRockDigital\Api\Actions\Me\SendPasswordReset;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Password\PasswordResetLinkRequest;
use Illuminate\Http\JsonResponse;

class PasswordResetLinkController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'forgot-password' => false,
    ];

    /**
     * @param  SendPasswordReset  $sendPasswordReset
     * @param  PasswordResetLinkRequest  $request
     * @return JsonResponse
     */
    public function store(SendPasswordReset $sendPasswordReset, PasswordResetLinkRequest $request): JsonResponse
    {
        $sendPasswordReset($request->get(config('base.auth.username')));

        return $this->response->setStatusCode(201);
    }
}
