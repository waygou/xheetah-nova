<?php

namespace Waygou\XheetahNova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class DeliveryStatus extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\DeliveryStatus::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name', 'description',
    ];

    public static $with = ['deliveries'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
    }

    public function subtitle()
    {
        return "{$this->description}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable()
              ->canSee(function ($request) {
                  return user_is('super-admin');
              }),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            ),

            Text::make(
                trans('xheetah-nova::fields.common.description'),
                'description'
            ),

            HasMany::make(
                trans('xheetah-nova::resources.deliveries.plural'),
                'deliveries',
                \Waygou\XheetahNova\Resources\Delivery::class
            ),
        ];
    }
}
