<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class VehicleType extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\VehicleType::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name',
    ];

    public static $with = [];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            ),

            Text::make(
                trans('xheetah-nova::fields.common.code'),
                'code'
            )->creationRules('unique:tenant.vehicle_types,code', 'max:191')
             ->updateRules('unique:tenant.vehicle_types,code,{{resourceId}}'),

            HasMany::make(
                trans('xheetah-nova::resources.vehicles.plural'),
                'vehicles',
                \Waygou\XheetahNova\Resources\Vehicle::class
            ),
        ];
    }
}
