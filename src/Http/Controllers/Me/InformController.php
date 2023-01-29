<?php

namespace RedRockDigital\Api\Http\Controllers\Me;

use RedRockDigital\Api\Actions\Me\UpdateInformAction;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Me\UpdateInformableRequest;
use RedRockDigital\Api\Http\Resources\InformableResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InformController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.inform.index'  => false,
        'me.inform.update' => false,
    ];

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->response->respond(
            InformableResource::collection($request->user()->informs)
        );
    }

    /**
     * @param UpdateInformAction      $updateInformAction
     * @param UpdateInformableRequest $request
     *
     * @return JsonResponse
     */
    public function update(
        UpdateInformAction $updateInformAction,
        UpdateInformableRequest $request
    ): JsonResponse {
        if ($updateInformAction(inform: $request->informable)) {
            return $this->response->created();
        }

        return $this->response->deleted();
    }
}
