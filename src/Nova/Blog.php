<?php

namespace RedRockDigital\Api\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\{
    Date,
    File,
    ID,
    Markdown,
    Number,
    Text,
    Textarea
};
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

/**
 * Class Team
 */
class Blog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\RedRockDigital\Api\Models\Blog>
     */
    public static string $model = \RedRockDigital\Api\Models\Blog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'author',
        'categories',
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
            Text::make('Title')->sortable()->required(),
            Text::make('Author')->sortable()->required(),
            Tags::make('Categories')->sortable()->canBeDeselected(),
            Number::make('Estimated Read Time (minutes)', 'estimate_read_time')
                ->hideFromIndex()
                ->required(),
            Textarea::make('Snippet')->hideFromIndex()->required(),
            Markdown::make('Body')->hideFromIndex()->required(),
            File::make('Featured Image')
                ->disk(config('filesystems.default'))
                ->store(fn(Request $request) => [
                    'featured_image' => $request->featured_image->storePublicly('public'),
                ])
                ->hideFromIndex()
                ->required(),
            Date::make('Published At')->sortable(),
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
        return [];
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
}
