<?php

namespace RedRockDigital\Api\Http\Controllers\Team;

use RedRockDigital\Api\Actions\Team\CreateTeam;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Team\CreateTeamRequest;
use RedRockDigital\Api\Http\Requests\Team\UpdateTeamRequest;
use RedRockDigital\Api\Models\Team;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    /**
     * @var array
     */
    public array $scopes = [
        'team.store'  => false,
        'team.update' => 'team.manage',
    ];

    /**
     * @param  CreateTeam  $createTeam
     * @param  CreateTeamRequest  $request
     * @return JsonResponse
     */
    public function store(CreateTeam $createTeam, CreateTeamRequest $request): JsonResponse
    {
        return $this->response->created($createTeam($request->user()->id, $request->get('name')));
    }

    /**
     * @param  Team  $team
     * @param  UpdateTeamRequest  $request
     * @return JsonResponse
     */
    public function update(Team $team, UpdateTeamRequest $request): JsonResponse
    {
        $team->update($request->validated());

        return $this->response->respond($team);
    }
}
