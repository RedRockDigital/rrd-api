<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Me\UpdateMeRequest;
use App\Http\Resources\MeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.show'   => false,
        'me.update' => false,
    ];

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        return $this->response->respond(new MeResource($request->user()));
    }

    /**
     * @param  UpdateMeRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateMeRequest $request): JsonResponse
    {
        $user = $request->user();

        $user->update($request->validated());

        return $this->response->respond(new JsonResource($user));
    }
}
