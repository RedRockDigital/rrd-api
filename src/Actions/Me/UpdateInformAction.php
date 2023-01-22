<?php

namespace App\Actions\Me;

use App\Enums\InformEnums;
use App\Models\User;

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
        $inform = InformEnums::fromName($inform);

        if ($inform !== null) {
            $user->canBeInformed($inform) ? $user->unInform($inform) : $user->inform($inform);
        }

        return $user->canBeInformed($inform);
    }
}
