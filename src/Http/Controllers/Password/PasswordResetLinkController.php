<?php

namespace App\Http\Controllers\Password;

use App\Actions\Me\SendPasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Requests\Password\PasswordResetLinkRequest;
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
