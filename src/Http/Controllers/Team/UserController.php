<?php

namespace RedRockDigital\Api\Http\Controllers\Team;

use RedRockDigital\Api\Actions\Team\InviteUser;
use RedRockDigital\Api\Actions\Team\RemoveUserFromTeam;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Team\{CreateUserRequest, UpdateUserRequest};
use RedRockDigital\Api\Http\Resources\Team\UserResource;
use RedRockDigital\Api\Models\User;
use Illuminate\Http\JsonResponse;

use Illuminate\Validation\ValidationException;

use function team;

class UserController extends Controller
{
    /**
     * @var array|string[]
     */
    public array $scopes = [
        'team.users.index'   => 'team.manage',
        'team.users.store'   => 'team.manage',
        'team.users.update'  => 'team.manage',
        'team.users.destroy' => 'team.manage',
    ];

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this
            ->response
            ->paginate(
                UserResource::collection(
                    team()->users()->with('groups')->paginate()
                )
            );
    }

    /**
     * @param InviteUser        $inviteUser
     * @param CreateUserRequest $request
     *
     * @return JsonResponse
     */
    public function store(InviteUser $inviteUser, CreateUserRequest $request): JsonResponse
    {
        $user = $inviteUser($request);

        return $this->response->created($user);
    }

    /**
     * @param User              $user
     * @param UpdateUserRequest $request
     *
     * @return JsonResponse
     */
    public function update(User $user, UpdateUserRequest $request): JsonResponse
    {
        team()->users()->updateExistingPivot($user->id, [
            'group_id' => $request->get('group_id'),
        ]);

        return $this->response->respond();
    }

    /**
     * @param RemoveUserFromTeam $removeUserFromTeam
     * @param User               $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function destroy(RemoveUserFromTeam $removeUserFromTeam, User $user): JsonResponse
    {
        $removeUserFromTeam($user);

        return $this->response->deleted();
    }
}
