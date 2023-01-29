<?php

namespace RedRockDigital\Api\Http\Controllers\Me;

use RedRockDigital\Api\Actions\Me\VerifyTwoFactor;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Me\VerifyTwoFactorRequest;
use Illuminate\Http\JsonResponse;

class VerifyTwoFactorController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.2fa.verify' => false,
    ];

    /**
     * @param  VerifyTwoFactor  $verifyTwoFactor
     * @param  VerifyTwoFactorRequest  $request
     * @return JsonResponse
     */
    public function __invoke(VerifyTwoFactor $verifyTwoFactor, VerifyTwoFactorRequest $request): JsonResponse
    {
        return $this->response->respond([
            'verified' => $verifyTwoFactor($request->user(), $request->get('code')),
        ]);
    }
}
