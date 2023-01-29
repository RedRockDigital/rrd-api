<?php

namespace RedRockDigital\Api\Http\Controllers\Me;

use RedRockDigital\Api\Actions\Me\DisableTwoFactor;
use RedRockDigital\Api\Actions\Me\EnableTwoFactor;
use RedRockDigital\Api\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.2fa.enable'  => false,
        'me.2fa.disable' => false,
    ];

    /**
     * @param  EnableTwoFactor  $enableTwoFactor
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(EnableTwoFactor $enableTwoFactor, Request $request): JsonResponse
    {
        $enableTwoFactor($request->user());

        return $this->response->created();
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function destroy(DisableTwoFactor $disableTwoFactor, Request $request): JsonResponse
    {
        $disableTwoFactor($request->user());

        return $this->response->deleted();
    }
}
