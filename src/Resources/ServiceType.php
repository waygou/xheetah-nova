<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;
use Waygou\NovaUx\Components\Fields\BelongsTo;

class ServiceType extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\ServiceType::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'id', 'name',
    ];

    public static $searchRelations = [
        'durationType' => ['name'],
        'vehicleType'  => ['name'],
        'client'       => ['name'],
    ];

    public static $with = [];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable()
              ->onlyOnForms(),

            Text::make(trans('xheetah-nova::fields.name'), 'name'),

            Text::make(trans('xheetah-nova::fields.code'), 'code'),

            BelongsTo::make(trans('xheetah-nova::fields.duration_type'), 'durationType', \Waygou\XheetahNova\Resources\DurationType::class),

            BelongsTo::make(trans('xheetah-nova::fields.vehicle_type'), 'vehicleType', \Waygou\XheetahNova\Resources\VehicleType::class),

            BelongsTo::make(trans('xheetah-nova::fields.client'), 'client', \Waygou\XheetahNova\Resources\Client::class)
                     ->help(trans('xheetah-nova::help.service_type.client')),

            Number::make(trans('xheetah-nova::fields.price_request'), 'price_request')->step(0.01),

            Number::make(trans('xheetah-nova::fields.price_request_additional'), 'price_request_additional')->step(0.01),

            Number::make(trans('xheetah-nova::fields.price_km'), 'price_km')->step(0.01),

            Number::make(trans('xheetah-nova::fields.price_km_additional'), 'price_km_additional')->step(0.01),

        ];
    }
}
