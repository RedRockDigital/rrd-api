<?php

namespace RedRockDigital\Api\Nova;

use RedRockDigital\Api\Nova\Actions\User\{
    CreateUser,
    RequestPasswordReset,
    SuspensionUser
};
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{
    Boolean,
    HasManyThrough,
    ID,
    Text
};
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class User
 *
 * @property-read \RedRockDigital\Api\Models\User $resource
 */
class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \RedRockDigital\Api\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     *
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->hideFromIndex(),

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

            Boolean::make('Suspended'),

            HasManyThrough::make(
                'Teams', 'teams', Team::class
            ),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
     *
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param NovaRequest $request
     *
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param NovaRequest $request
     *
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     *
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [
            CreateUser::make()->standalone()->onlyOnIndex(),
            RequestPasswordReset::make()->onlyInline()->showOnDetail(),
            SuspensionUser::make()
                ->showInline()
                ->setText($this->resource->suspended ?? false),
        ];
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function authorizedToView(Request $request): bool
    {
        return true;
    }
}
