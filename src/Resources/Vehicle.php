<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;
use Waygou\XheetahNovaUI\Components\Fields\BelongsTo;

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

            Text::make(trans('xheetah-nova::fields.brandmodel'), 'brandmodel'),

            Date::make(trans('xheetah-nova::fields.since')),

            Text::make(trans('xheetah-nova::fields.registration'))
                ->help(trans('xheetah-nova::help.registration')),

            Text::make(trans('xheetah-nova::fields.license_plate')),

            Text::make('Courier', function () {
                if (!is_null($this->user)) {
                    return "<span via-resource='vehicles' via-resource-id='{$this->id}' class='text-left'><span><a href='/nova/resources/couriers/{$this->user->id}' class='no-underline dim text-primary font-bold'>{$this->user->name}</a></span></span>";
                }

                return '—';
            })->asHtml()
              ->onlyOnIndex(),

            BelongsTo::make('Vehicle Type', 'vehicleType', \Waygou\XheetahNova\Resources\VehicleType::class),

            HasOne::make(trans('xheetah-nova::resources.couriers.singular'), 'user', \Waygou\XheetahNova\Resources\Courier::class),
        ];
    }
}
