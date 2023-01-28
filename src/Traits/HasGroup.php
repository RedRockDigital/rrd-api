<?php

namespace RedRockDigital\Api\Traits;

use RedRockDigital\Api\Exceptions\RoleNotFoundException;
use RedRockDigital\Api\Models\Group;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait HasRoles
 */
trait HasGroup
{
    use HasScope;

    /**
     * User belongs to many Roles
     *
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this
            ->belongsToMany(Group::class, 'team_user', 'user_id', 'group_id')
            ->where('team_id', \team()->id)
            ->withTimestamps();
    }

    /**
     * Attach a new Role to the users account.
     *
     * @param  string|null  $group
     * @param  null  $teamId
     * @return void
     */
    public function attachGroup(string $group = null, $teamId = null): void
    {
        if ($group === null) {
            return;
        }

        /** @var Group $group */
        $groupModel = Group::whereRef($group)->firstOrFail();

        if ($groupModel === null) {
            throw new RoleNotFoundException($role);
        }

        $this->teams()->attach($teamId, ['group_id' => $groupModel->id]);
    }
}
