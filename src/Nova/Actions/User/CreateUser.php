<?php

namespace RedRockDigital\Api\Nova\Actions\User;

use RedRockDigital\Api\Actions\Me\CreateUser as CreateUserAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class CreateUser
 */
final class CreateUser extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * @var string
     */
    public $name = 'Create User';

    /**
     * @var string
     */
    public $confirmText = 'Fill in the basic users details below in order to create their account.';

    /**
     * @var string
     */
    public $confirmButtonText = 'Create User';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        $query = request()->query;

        if ($query->get('viaResource') === 'teams') {
            $teamId = $query->get('viaResourceId');
        }

        \actions(
            CreateUserAction::class,
            firstName: $fields->get('first_name'),
            lastName: $fields->get('last_name'),
            email: $fields->get('email'),
            password: $fields->get('password'),
            teamId: $teamId ?? null
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
        return [
            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
        ];
    }
}
