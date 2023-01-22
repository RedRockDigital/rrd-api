<?php

namespace RedRockDigital\Api\Http\Controllers;

use RedRockDigital\Api\Actions\Me\CreateUser;
use RedRockDigital\Api\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RegisterController
 */
final class RegisterController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'register' => false,
    ];

    /**
     * @param  CreateUser  $createUser
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function store(CreateUser $createUser, RegisterRequest $request): JsonResponse
    {
        return $this->response->created(
            new JsonResource(
                $createUser(
                    firstName: $request->first_name,
                    lastName: $request->last_name,
                    email: $request->email,
                    password: $request->password,
                    referral: $request->referral,
                )
            )
        );
    }
}
