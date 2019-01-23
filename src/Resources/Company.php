<?php

namespace Waygou\GamestageNova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Waygou\GamestageNova\Abstracts\GamestageResource;

class Company extends GamestageResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Waygou\Gamestage\Models\Company::class;

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

            HasMany::make(
                'Games as Developer',
                'developers',
                \Waygou\GamestageNova\Resources\Game::class
            ),

            HasMany::make(
                'Games as Publisher',
                'publishers',
                \Waygou\GamestageNova\Resources\Game::class
            ),

            HasMany::make(
                'Games as Re-Releaser',
                're_releasers',
                \Waygou\GamestageNova\Resources\Game::class
            ),

            HasMany::make(
                'Games as Licencer',
                'licencers',
                \Waygou\GamestageNova\Resources\Game::class
            )
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
