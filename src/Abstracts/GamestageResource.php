<?php

namespace Waygou\GamestageNova\Abstracts;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class GamestageResource extends Resource
{
    public static $indexDefaultOrder = [];

    public static $cards = [];

    public static function softDeletes()
    {
        return (static::authorizable() ? Gate::check(
            'withTrashed',
            [static::newModel()]
        ) : true) && parent::softDeletes();
    }

    public function cards(Request $request)
    {
        $cards = [];

        return $cards;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy')) && ! empty(static::$indexDefaultOrder)) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
        }

        return $query;
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
