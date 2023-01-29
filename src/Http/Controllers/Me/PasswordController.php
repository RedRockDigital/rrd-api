<?php

namespace RedRockDigital\Api\Http\Controllers\Me;

use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Me\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

class PasswordController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.update.password' => false,
    ];

    /**
     * @param  UpdatePasswordRequest  $request
     * @return JsonResponse
     */
    public function update(UpdatePasswordRequest $request): JsonResponse
    {
        $request->user()->updateQuietly([
            'password' => $request->get('password'),
        ]);

        return $this->response->setStatusCode(200);
    }
}
