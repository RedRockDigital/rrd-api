<?php

namespace RedRockDigital\Api\Actions\Me;

use RedRockDigital\Api\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MarkNotificationAsRead
{
    /**
     * @param  User  $user
     * @param  string  $notificationId
     * @return void
     */
    public function __invoke(User $user, string $notificationId): void
    {
        if (!$user->notifications()->where('id', $notificationId)->exists()) {
            throw new NotFoundHttpException();
        }

        $user->notifications()->where('id', $notificationId)->update([
            'read_at' => now(),
        ]);
    }
}
