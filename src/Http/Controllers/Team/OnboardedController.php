<?php

namespace RedRockDigital\Api\Http\Controllers\Team;

use RedRockDigital\Api\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class OnboardedController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'team.onboarded' => false,
    ];

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $team = \team();

        $team->update([
            'has_onboarded' => true,
        ]);

        return $this->response->respond($team);
    }
}
