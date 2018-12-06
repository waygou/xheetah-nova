<?php

namespace Waygou\XheetahNova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class DeliveryType extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\DeliveryType::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name',
    ];

    public static $searchRelations = [
        'durationType' => ['name'],
        'vehicleType'  => ['name'],
        'client'       => ['name'],
    ];

    public static $with = ['durationType', 'vehicleType', 'client'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
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
            )->rules('required'),

            BelongsTo::make(
                trans('xheetah-nova::fields.delivery_types.duration_type'),
                'durationType',
                \Waygou\XheetahNova\Resources\DurationType::class
            )->rules('required'),

            BelongsTo::make(
                trans('xheetah-nova::fields.delivery_types.vehicle_type'),
                'vehicleType',
                \Waygou\XheetahNova\Resources\VehicleType::class
            )->rules('required'),

            BelongsTo::make(
                trans('xheetah-nova::fields.common.client'),
                'client',
                \Waygou\XheetahNova\Resources\Client::class
            )->nullable()
             ->help(
                 trans('xheetah-nova::help.delivery_types.client')
             ),

            Number::make(
                trans('xheetah-nova::fields.delivery_types.price_request'),
                'price_request'
            )->step(0.01)
             ->rules('required'),

            Number::make(
                trans('xheetah-nova::fields.delivery_types.price_request_additional'),
                'price_request_additional'
            )->step(0.01)
             ->rules('required'),

            Number::make(
                trans('xheetah-nova::fields.delivery_types.price_km'),
                'price_km'
            )->step(0.01)
             ->rules('required'),

            Number::make(
                trans('xheetah-nova::fields.delivery_types.price_km_additional'),
                'price_km_additional'
            )->step(0.01)
             ->rules('required'),

        ];
    }
}
