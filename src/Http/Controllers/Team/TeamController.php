<?php

namespace App\Http\Controllers\Team;

use App\Actions\Team\CreateTeam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\CreateTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Team;
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
