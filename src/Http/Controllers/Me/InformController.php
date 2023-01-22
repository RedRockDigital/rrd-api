<?php

namespace App\Http\Controllers\Me;

use App\Actions\Me\UpdateInformAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Me\UpdateInformableRequest;
use App\Http\Resources\InformableResource;
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
