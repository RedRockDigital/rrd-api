<?php

namespace RedRockDigital\Api\Policies;

use RedRockDigital\Api\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can upload files.
     *
     * @param  User  $user
     * @return mixed
     */
    public function uploadFiles(User $user): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function view(): bool
    {
        if ($this->isNovaRoute()) {
            return true;
        }

        return false;
    }

    /**
     * @param  User  $loggedInUser
     * @param  User  $user
     * @return bool
     */
    public function update(User $loggedInUser, User $user): bool
    {
        if ($this->isNovaRoute()) {
            return true;
        }

        if ($loggedInUser->id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isNovaRoute(): bool
    {
        return str_contains(request()?->getPathInfo(), '/nova-api/');
    }
}
