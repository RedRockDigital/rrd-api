<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Me\UpdatePasswordRequest;
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
