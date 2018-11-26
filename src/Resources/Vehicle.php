<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class Vehicle extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Vehicle::class;

    public static $title = 'brandmodel';

    public static $displayInNavigation = true;

    public static $search = [
        'id', 'brandmodel', 'registration',  'license_plate',
    ];

    public static $with = [];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
    }

    public function subtitle()
    {
        return "{$this->licence_plate}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->onlyOnForms(),

            Text::make(trans('xheetah-nova::fields.vehicles.brandmodel'), 'brandmodel'),

            Date::make(trans('xheetah-nova::fields.common.since')),

            Text::make(trans('xheetah-nova::fields.common.registration'))
                ->help(trans('xheetah-nova::help.vehicles.registration')),

            Text::make(trans('xheetah-nova::fields.common.license_plate')),

            Text::make(trans('xheetah-nova::fields.common.courier'), function () {
                if (!is_null($this->user)) {
                    return "<span via-resource='vehicles' via-resource-id='{$this->id}' class='text-left'><span><a href='/nova/resources/couriers/{$this->user->id}' class='no-underline dim text-primary font-bold'>{$this->user->name}</a></span></span>";
                }
                return '—';
            })->asHtml()
              ->onlyOnIndex(),

            BelongsTo::make(trans('xheetah-nova::fields.vehicles.type'), 'vehicleType', \Waygou\XheetahNova\Resources\VehicleType::class),

            HasOne::make(trans('xheetah-nova::resources.couriers.singular'), 'user', \Waygou\XheetahNova\Resources\Courier::class),
        ];
    }
}
