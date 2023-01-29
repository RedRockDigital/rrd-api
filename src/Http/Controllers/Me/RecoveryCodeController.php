<?php

namespace RedRockDigital\Api\Http\Controllers\Me;

use RedRockDigital\Api\Actions\Me\CreateRecoveryCodes;
use RedRockDigital\Api\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\{
    JsonResponse,
    Request,
};

class RecoveryCodeController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.2fa.get-recovery-codes'    => false,
        'me.2fa.create-recovery-codes' => false,
    ];

    /**
     * @param  Request  $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        return new JsonResource([
            'codes' => $request->user()->recoveryCodes(),
        ]);
    }

    /**
     * @param CreateRecoveryCodes $createRecoveryCodes
     * @param Request $request
     * @return JsonResponse
     */
    public function store(CreateRecoveryCodes $createRecoveryCodes, Request $request): JsonResponse
    {
        return $this->response->response([
            'codes' => $createRecoveryCodes($request->user()),
        ]);
    }
}
