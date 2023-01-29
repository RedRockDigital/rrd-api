<?php

namespace RedRockDigital\Api\Http\Controllers;

use RedRockDigital\Api\Actions\Me\VerifyEmail;
use RedRockDigital\Api\Http\Requests\VerifyEmailRequest;
use RedRockDigital\Api\Http\Resources\VerifyEmailResource;
use RedRockDigital\Api\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'verify-email' => false,
    ];

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->get('user'));

        if (!$user?->authoriseVerification((string) $request->get('token'))) {
            return abort(404);
        }

        return $this->response->respond(new VerifyEmailResource($user));
    }

    /**
     * @param  VerifyEmail  $verifyEmail
     * @param  VerifyEmailRequest  $request
     * @return JsonResponse
     */
    public function store(VerifyEmail $verifyEmail, VerifyEmailRequest $request): JsonResponse
    {
        return $this->response->respond($verifyEmail(
            $request->get('user'),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('password')
        ));
    }
}
