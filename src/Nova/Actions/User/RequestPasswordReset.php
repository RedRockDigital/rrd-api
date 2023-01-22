<?php

namespace App\Nova\Actions\User;

use App\Actions\Me\SendPasswordReset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\{
    ActionFields
};
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class RequestPasswordReset
 */
final class RequestPasswordReset extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Request Password Reset';

    public $confirmText = 'Send a password reset link directly to the user, they will receive an email
    containing a link to where they will be able to set a new password.';

    public $confirmButtonText = 'Yes, request reset!';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        /** @var User $user */
        $user = $models->first();

        actions(
            SendPasswordReset::class,
            username: $user->email
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
