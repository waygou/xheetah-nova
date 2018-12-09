<?php

namespace Waygou\XheetahNova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Waygou\Xheetah\Models\User;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\DateTime;
use Waygou\Xheetah\Models\Client;
use Illuminate\Support\Facades\Auth;
use Waygou\NovaUx\Components\Fields\Map;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\NovaUx\Components\Fields\Place;
use Waygou\NovaUx\Components\Fields\Topic;
use Waygou\NovaUx\Components\Fields\Select;
use Waygou\NovaUx\Components\Fields\Textarea;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class Delivery extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Delivery::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'origin_address', 'destination_address',
    ];

    public static $searchRelations = [
        'client'      => ['name'],
        'costCenter'  => ['name'],
        'deliveryType' => ['name'],
        'creator'     => ['name'],
        'courier'     => ['name'],
    ];

    public static $with = ['client', 'costCenter', 'deliveryType', 'creator', 'courier'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.entities');
    }

    public function subtitle()
    {
        return "{$this->client->name} {$this->courier->name}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable()
              ->canSee(function ($request) {
                  return user_is('super-admin');
              }),

            Topic::make(
                trans('xheetah-nova::topics.client_information')
            )->withSVG('icon-user'),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.client'),
                'client',
                \Waygou\XheetahNova\Resources\Client::class
            ),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.cost_center'),
                'costCenter',
                \Waygou\XheetahNova\Resources\CostCenter::class
            )->nullable()
             ->affectedBy(
                 'client',
                 'Waygou\Xheetah\Restrictions\CostCenterRestriction@restrictToClient'
             )->hideFromIndex(),

            Topic::make(
                trans('xheetah-nova::topics.deliveries.delivery_type')
            )->withSVG('queue'),

            Text::make(
                trans('xheetah-nova::fields.deliveries.created_by'),
                'created_by'
            )->hideFromIndex()
             ->readonly()
             ->onCreateDefault(Auth::user()->name),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.delivery_type'),
                'deliveryType',
                \Waygou\XheetahNova\Resources\DeliveryType::class
            ),

            Boolean::make(
                trans('xheetah-nova::fields.deliveries.with_return'),
                'with_return'
            )->help(trans('xheetah-nova::help.deliveries.with_return')),

            Textarea::make(
                trans('xheetah-nova::fields.deliveries.notes'),
                'notes'
            )->hideFromIndex(),

            Topic::make(
                trans('xheetah-nova::topics.deliveries.related_addresses')
            )->withSVG('inbox-full'),

            Select::make(
                trans('xheetah-nova::fields.deliveries.origin_related_address'),
                'origin_related_address'
            )->nullable()
             ->hideFromIndex()
             ->affectedBy(
                 'client',
                 'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
             )
             ->affectedBy(
                 'costCenter',
                 'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
             )->help(trans('xheetah-nova::help.deliveries.related_address')),

            Select::make(
                trans('xheetah-nova::fields.deliveries.destination_related_address'),
                'destination_related_address'
            )
            ->nullable()
            ->hideFromIndex()
            ->affectedBy(
                'client',
                'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
            )
            ->affectedBy(
                'costCenter',
                'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
            )->help(trans('xheetah-nova::help.deliveries.related_address')),

            Topic::make(
                trans('xheetah-nova::topics.deliveries.origin_location')
            )
            ->withSVG('location'),

            Place::make(
                trans('xheetah-nova::fields.deliveries.address'),
                'origin_address'
            )
                 ->postalCode('origin_postal_code')
                 ->city('origin_city')
                 ->locality('origin_locality')
                 ->countryCode('origin_country_code')
                 ->country('origin_country')
                 ->map('origin_map')
                 ->hideFromIndex()
                 ->affectedBy(
                     'origin_related_address',
                     'Waygou\Xheetah\Restrictions\AddressRestriction@loadPlace'
                 )->hideFromIndex(),

            Text::make(trans('xheetah-nova::fields.common.from'), function () {
                return $this->origin_address . ', ' . $this->origin_floor_number . ', ' . $this->origin_locality . ', ' . $this->origin_city;
            })->onlyOnIndex(),

            Text::make(
                trans('xheetah-nova::fields.common.floor_number'),
                'origin_floor_number'
            )->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.postal_code'),
                'origin_postal_code'
            )->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.city'),
                'origin_city'
            )->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.locality'),
                'origin_locality'
            )->hideFromIndex(),

            Country::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'origin_country_code'
            )->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'origin_country'
            )->hidden()
             ->hideFromIndex(),

            Map::make(
                trans('xheetah-nova::fields.deliveries.address_location'),
                'origin_map'
            )->hideFromIndex(),

            Topic::make(
                trans('xheetah-nova::topics.deliveries.destination_location')
            )
                  ->withSVG('location'),

            Place::make(
                trans('xheetah-nova::fields.deliveries.address'),
                'destination_address'
            )
                 ->postalCode('destination_postal_code')
                 ->city('destination_city')
                 ->locality('destination_locality')
                 ->countryCode('destination_country_code')
                 ->country('destination_country')
                 ->map('destination_map')
                 ->affectedBy(
                     'destination_related_address',
                     'Waygou\Xheetah\Restrictions\AddressRestriction@loadPlace'
                 )->hideFromIndex(),

            Text::make(trans('xheetah-nova::fields.common.to'), function () {
                return $this->destination_address . ', ' . $this->destination_floor_number . ', ' . $this->destination_locality . ', ' . $this->destination_city;
            })->onlyOnIndex(),

            Text::make(
                trans('xheetah-nova::fields.common.floor_number'),
                'destination_floor_number'
            )->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.postal_code'),
                'destination_postal_code'
            )->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.city'),
                'destination_city'
            )->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.locality'),
                'destination_locality'
            )->hideFromIndex(),

            Country::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'destination_country_code'
            )
                ->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'destination_country'
            )->hidden()
             ->hideFromIndex(),

            Map::make(
                trans('xheetah-nova::fields.deliveries.address_location'),
                'destination_map'
            )->hideFromIndex(),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.assigned_to'),
                'courier',
                \Waygou\XheetahNova\Resources\Courier::class
            )->nullable()
             ->canSee(function ($request) {
                 return user_is(['super-admin', 'employee-coordination', 'admin', 'employee-standard']);
             }),

            Topic::make(
                trans('xheetah-nova::topics.deliveries.merchandise_information')
            )
                  ->withSVG('box'),

            Number::make(
                trans('xheetah-nova::fields.deliveries.volumes_qty'),
                'volumes_qty'
            )->hideFromIndex(),

            Number::make(
                trans('xheetah-nova::fields.deliveries.volumes_total_weight'),
                'volumes_qty'
            )->hideFromIndex(),

            Textarea::make(
                trans('xheetah-nova::fields.deliveries.merchandise_description'),
                'merchandise_description'
            )->hideFromIndex(),

            Number::make(
                trans('xheetah-nova::fields.deliveries.price_request'),
                'price_request'
            )->hideFromIndex()
             ->step(0.01),

            Topic::make(
                trans('xheetah-nova::topics.deliveries.schedule_information')
            )
                  ->withSVG('calendar'),

            Select::make(
                trans('xheetah-nova::fields.deliveries.schedule_type'),
                'schedule_type'
            )->options(['asap' => 'As soon as possible', 'future' => 'To start later'])
             ->hideFromIndex()
             ->displayUsingLabels(),

            DateTime::make(
                trans('xheetah-nova::fields.deliveries.schedule_planned_at'),
                'schedule_planned_at'
            )->hideFromIndex(),

            Textarea::make(
                trans('xheetah-nova::fields.deliveries.comments_courier'),
                'comments_courier'
            ),

            Textarea::make(
                trans('xheetah-nova::fields.deliveries.comments_internal'),
                'comments_internal'
            ),
        ];
    }
}
