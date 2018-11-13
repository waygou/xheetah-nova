<?php

namespace Waygou\XheetahNova\Abstracts;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Titasgailius\SearchRelations\SearchesRelations;
use Waygou\ResourceHeaderCard\ResourceHeaderCard;
use Waygou\XheetahUtils\Models\SvgIcon;

abstract class XheetahResource extends Resource
{
    use SearchesRelations;

    public static $indexDefaultOrder = [];

    public static $cards = [];

    /**
     * The relationship columns that should be searched.
     *
     * @link https://novapackages.com/packages/titasgailius/search-relations Nova package.
     *
     * @var array
     */
    public static $searchRelations = [
    ];

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

        // Verify if we have a resource translation header for the respective resource name.
        $computedLabel = snake_case(strtolower(str_plural(collect(explode('\\', get_called_class()))->pop())));

        if (is_array(xheetah_trans("resources.{$computedLabel}.header"))) {
            $header = xheetah_trans("resources.{$computedLabel}.header");

            // Load the resource header card.
            $cards = array_merge($cards, [(new ResourceHeaderCard())
                ->withSVG(SvgIcon::where('name', $header['svg_name'])->first()->path)
                ->withHeader($header['title'] ?? null)
                ->withContentLine1($header['line_1'] ?? null)
                ->withContentLine2($header['line_2'] ?? null)
                ->withContentLine3($header['line_3'] ?? null)
                ->withLink($header['link']['text'] ?? null, $header['link']['url']), ]);
        }

        // Load the remaining cards.
        $cards = array_merge($cards, static::$cards);

        return $cards;
    }

    public static function label()
    {
        $computedLabel = str_plural(snake_case(collect(explode('\\', get_called_class()))->pop()));

        return trans("xheetah-nova::resources.{$computedLabel}.plural");
    }

    public static function singularLabel()
    {
        $computedLabel = str_plural(snake_case(collect(explode('\\', get_called_class()))->pop()));

        return xheetah_trans("resources.{$computedLabel}.singular");
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy')) && !empty(static::$indexDefaultOrder)) {
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
