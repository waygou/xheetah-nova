<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Waygou\XheetahNova\Abstracts\XheetahResource;
use Waygou\Xheetah\Models\Client;
use Waygou\Xheetah\Models\User;
use Waygou\XheetahNovaUI\Components\Fields\BelongsTo;
use Waygou\XheetahNovaUI\Components\Fields\Map;
use Waygou\XheetahNovaUI\Components\Fields\Place;
use Waygou\XheetahNovaUI\Components\Fields\Select;
use Waygou\XheetahNovaUI\Components\Fields\Text;
use Waygou\XheetahNovaUI\Components\Fields\Textarea;
use Waygou\XheetahNovaUI\Components\Fields\Topic;

class Delivery extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Delivery::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'id', 'origin_address', 'destination_address',
    ];

    public static $searchRelations = [
        'client'      => ['name'],
        'costCenter'  => ['name'],
        'serviceType' => ['name'],
        'creator'     => ['name'],
        'courier'     => ['name'],
    ];

    public static $with = ['client', 'costCenter', 'serviceType', 'creator', 'courier'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.entities');
    }

    public function subtitle()
    {
        return "{$this->client->name}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable()
              ->canSee(function ($request) {
                  return user_is('super-admin');
              }),

            Topic::make(trans('xheetah-nova::topics.client_information'))
                  ->withSVG('icon-user'),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.client'),
                'client',
                \Waygou\XheetahNova\Resources\Client::class
            ),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.cost_center'),
                'costCenter',
                \Waygou\XheetahNova\Resources\CostCenter::class
            )
            ->nullable()
            ->startEmpty()
            ->affectedBy(
                'client',
                'Waygou\Xheetah\Restrictions\CostCenterRestriction@restrictToClient'
            ),

            Topic::make(trans('xheetah-nova::topics.deliveries.delivery_type'))
                  ->withSVG('queue'),

            Text::make(trans('xheetah-nova::fields.deliveries.created_by'), 'created_by')
                ->readonly()
                ->onCreateDefault(Auth::user()->name),

            BelongsTo::make(
                trans('xheetah-nova::fields.deliveries.delivery_type'),
                'serviceType',
                \Waygou\XheetahNova\Resources\ServiceType::class
            ),

            Boolean::make(trans('xheetah-nova::fields.deliveries.with_return'), 'with_return'),

            Textarea::make(trans('xheetah-nova::fields.deliveries.notes'), 'notes'),

            Topic::make(trans('xheetah-nova::topics.deliveries.related_addresses'))
                  ->withSVG('inbox-full'),

            Select::make(
                trans('xheetah-nova::fields.deliveries.origin_related_address'),
                'origin_related_address'
            )
                  ->nullable()
                  ->startEmpty()
                  ->affectedBy(
                      'client',
                      'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
                  )
                  ->affectedBy(
                      'costCenter',
                      'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
                  ),

            Select::make(
                trans('xheetah-nova::fields.deliveries.destination_related_address'),
                'destination_related_address'
            )
                  ->nullable()
                  ->startEmpty()
                  ->affectedBy(
                      'client',
                      'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
                  )
                  ->affectedBy(
                      'costCenter',
                      'Waygou\Xheetah\Restrictions\AddressRestriction@preloadAddresses'
                  ),

            Topic::make(trans('xheetah-nova::topics.deliveries.origin_location'))
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
                 ->affectedBy(
                     'origin_related_address',
                     'Waygou\Xheetah\Restrictions\AddressRestriction@loadPlace'
                 ),

            Text::make(trans('xheetah-nova::fields.deliveries.postal_code'), 'origin_postal_code'),

            Text::make(trans('xheetah-nova::fields.deliveries.city'), 'origin_city'),

            Text::make(trans('xheetah-nova::fields.deliveries.locality'), 'origin_locality'),

            Country::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'origin_country_code'
            )
                ->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'origin_country'
            )
                ->exceptOnForms(),

            Map::make(trans('xheetah-nova::fields.deliveries.address_location'), 'origin_map'),

            Topic::make(trans('xheetah-nova::topics.deliveries.destination_location'))
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
                 ),

            Text::make(trans('xheetah-nova::fields.deliveries.postal_code'), 'destination_postal_code'),

            Text::make(trans('xheetah-nova::fields.deliveries.city'), 'destination_city'),

            Text::make(trans('xheetah-nova::fields.deliveries.locality'), 'destination_locality'),

            Country::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'destination_country_code'
            )
                ->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.deliveries.country'),
                'destination_country'
            )
                ->exceptOnForms(),

            Map::make(trans('xheetah-nova::fields.deliveries.address_location'), 'destination_map'),

            Topic::make(trans('xheetah-nova::topics.deliveries.merchandise_information'))
                  ->withSVG('box'),

            Number::make(
                trans('xheetah-nova::fields.deliveries.volumes_qty'),
                'volumes_qty'
            ),

            Number::make(
                trans('xheetah-nova::fields.deliveries.volumes_total_weight'),
                'volumes_qty'
            ),

            Textarea::make(
                trans('xheetah-nova::fields.deliveries.merchandise_description'),
                'merchandise_description'
            ),

            Number::make(
                trans('xheetah-nova::fields.deliveries.price_request'),
                'price_request'
            )->step(0.01),

            Topic::make(trans('xheetah-nova::topics.deliveries.schedule_information'))
                  ->withSVG('calendar'),

            Select::make(
                trans('xheetah-nova::fields.deliveries.schedule_type'),
                'schedule_type'
            )->options(['asap' => 'As soon as possible', 'future' => 'To start later'])
             ->displayUsingLabels(),

            DateTime::make(
                trans('xheetah-nova::fields.deliveries.schedule_planned_at'),
                'schedule_planned_at'
            ),

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
