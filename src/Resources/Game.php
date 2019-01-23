<?php

namespace Waygou\GamestageNova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Waygou\GamestageNova\Abstracts\GamestageResource;

class Game extends GamestageResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Waygou\Gamestage\Models\Game::class;

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
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make('Release Year', 'release_year'),

            BelongsTo::make(
                'Genre',
                'genre',
                \Waygou\GamestageNova\Resources\Genre::class
            ),

            BelongsTo::make(
                'Developer',
                'developer',
                \Waygou\GamestageNova\Resources\Company::class
            )->searchable(),

            BelongsTo::make(
                'Publisher',
                'publisher',
                \Waygou\GamestageNova\Resources\Company::class
            )->searchable(),

            BelongsTo::make(
                'Re-releaser',
                're_releaser',
                \Waygou\GamestageNova\Resources\Company::class
            )->searchable(),

            BelongsTo::make(
                'Licencer',
                'licencer',
                \Waygou\GamestageNova\Resources\Company::class
            )->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
