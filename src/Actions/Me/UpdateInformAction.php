<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Enums\InformEnums;
use RedRockDigital\Api\Models\User;

class UpdateInformAction
{
    /**
     * @param  User|null  $user
     * @param  string  $inform
     * @return bool
     */
    public function __invoke(User $user = null, string $inform = ''): bool
    {
        $user = $user ?? auth()->user();
        $inform = informable($inform);

        if ($inform !== null) {
            $user->canBeInformed($inform) ? $user->unInform($inform) : $user->inform($inform);
        }

        return $user->canBeInformed($inform);
    }
}
