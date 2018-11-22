<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;
use Waygou\NovaUx\Components\Fields\Map;
use Waygou\NovaUx\Components\Fields\Place;
use Waygou\NovaUx\Components\Fields\Text;

class Address extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Address::class;

    public static $title = 'address';

    public static $displayInNavigation = true;

    public static $search = [
        'name', 'address',
    ];

    public static $with = [];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.entities');
    }

    public function subtitle()
    {
        return "{$this->city}, {$this->locality}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
                ->sortable()
                ->canSee(function ($request) {
                    return user_is('super-admin');
                }),

            MorphTo::make(
                trans('xheetah-nova::fields.addresses.addressable'),
                'addressable'
            )->types([
                    Client::class,
                    CostCenter::class,
                    ]),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            )
                ->rules('required')
                ->help(trans('xheetah-nova::help.addresses.name')),

            Place::make(
                trans('xheetah-nova::fields.common.address'),
                'address'
            )
                ->rules('required'),

            Text::make(
                trans('xheetah-nova::fields.common.floor_number'),
                'floor_number'
            ),

            Text::make(
                trans('xheetah-nova::fields.common.postal_code'),
                'postal_code'
            ),

            Text::make(
                trans('xheetah-nova::fields.common.city'),
                'city'
            )
                ->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.common.locality'),
                'locality'
            ),

            Country::make(
                trans('xheetah-nova::fields.common.country'),
                'country_code'
            )
                ->rules('required')
                ->onlyOnForms()
                ->hideFromIndex()
                ->hideFromDetail(),

            Text::make(
                trans('xheetah-nova::fields.common.country'),
                'country'
            )
                ->hidden()
                ->hideFromIndex(),

            Map::make(
                trans('xheetah-nova::fields.common.map'),
                'map'
            ),
        ];
    }
}
