<?php

namespace RedRockDigital\Api\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\{
    HasManyThrough,
    ID,
    MultiSelect,
    Text,
};
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class Team
 */
class Team extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\RedRockDigital\Api\Models\Team>
     */
    public static string $model = \RedRockDigital\Api\Models\Team::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
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
            ID::make()->onlyOnDetail(),
            Text::make('Name')->sortable(),
            Text::make('Tier'),
            Text::make('Owner', function () {
                return $this?->owner?->email;
            })->onlyOnDetail(),
            MultiSelect::make('Features')->options(config('feature-flags'))->hideFromIndex(),
            HasManyThrough::make('Users'),
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
     * @param NovaRequest  $request
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
     * @param NovaRequest  $request
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
     * @param  NovaRequest  $request
     *
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }
}
