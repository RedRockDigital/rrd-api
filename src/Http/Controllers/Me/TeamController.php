<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Me\UpdateCurrentTeamRequest;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.update.team' => false,
    ];

    /**
     * @param  UpdateCurrentTeamRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateCurrentTeamRequest $request): JsonResponse
    {
        $request->user()->switchTeam(Team::findOrFail($request->get('team_id')));

        return $this->response->respond($request->user());
    }
}
