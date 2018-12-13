<?php

namespace Waygou\XheetahNova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class DeliveryStatusChange extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\DeliveryStatusChange::class;

    public static $title = '';

    public static $displayInNavigation = true;

    public static $search = [];

    public static $with = [];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
    }

    public function subtitle()
    {
        return '';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable()
              ->canSee(function ($request) {
                  return user_is('super-admin');
              }),

            BelongsTo::make(
                trans('xheetah-nova::resources.deliveries.singular'),
                'delivery',
                \Waygou\XheetahNova\Resources\Delivery::class
            ),
        ];
    }
}
