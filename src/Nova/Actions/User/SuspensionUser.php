<?php

namespace App\Nova\Actions\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class SuspensionUser
 */
final class SuspensionUser extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection   $models
     *
     * @return string[]
     */
    public function handle(ActionFields $fields, Collection $models): array
    {
        /** @var User $user */
        $user = $models->first();

        $user->updateQuietly(['suspended' => !$user->suspended]);

        return Action::message('User has been successfully updated.');
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }

    /**
     * @param bool $suspended
     *
     * @return SuspensionUser
     */
    public function setText(bool $suspended = false): SuspensionUser
    {
        $label = $this->resourceSuspendedLabel($suspended);

        $content = [
            'suspend'    => [
                'confirm' => 'This action will suspend the user, this will prevent the user from logging into the application. Are you sure you want to suspend this user?',
                'button'  => 'Yes, suspend user',
            ],
            'un-suspend' => [
                'confirm' => 'This action will un-suspend the user, this will allow the user to login to the application. Are you sure?',
                'button'  => 'Yes, un-suspend user',
            ],
        ];

        $this
            ->confirmText($content[$label]['confirm'])
            ->confirmButtonText($content[$label]['button']);

        return $this;
    }

    /**
     * @param bool $type
     *
     * @return string
     */
    private function resourceSuspendedLabel(bool $type): string
    {
        return $type ? 'un-suspend' : 'suspend';
    }
}
