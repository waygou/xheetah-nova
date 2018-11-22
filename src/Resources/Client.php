<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\NovaUx\Components\Fields\Topic;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class Client extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Client::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name', 'fiscal_number',
    ];

    public static $with = ['users'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.entities');
    }

    public function subtitle()
    {
        return "{$this->postal_code} {$this->city}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
                ->sortable()
                ->canSee(function ($request) {
                    return user_is('super-admin');
                }),

            Topic::make(trans('xheetah-nova::topics.clients.identification'))
                 ->withSVG('folder-outline'),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            )
                ->help(trans('xheetah-nova::help.clients.name'))
                ->rules('required'),

            Text::make(
                trans('xheetah-nova::fields.clients.social_designation'),
                'social_name'
            )
                ->onlyOnForms(),

            Date::make(
                trans('xheetah-nova::fields.clients.contract_starts_at'),
                'contract_start'
            )
                ->help(trans('xheetah-nova::help.clients.contract_starts_at'))
                ->rules('required')
                ->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.clients.fiscal_number'),
                'fiscal_number'
            )
                ->onlyOnForms(),

            Topic::make(trans('xheetah-nova::topics.clients.user_admin'))
                 ->withSVG('user'),

            Text::make(
                trans('xheetah-nova::fields.clients.contact_name'),
                'contact_name'
            )
                ->rules('required')
                ->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.clients.contact_phone'),
                'contact_phone'
            )
                ->hideFromIndex(),

            Email::make(
                trans('xheetah-nova::fields.clients.contact_email'),
                'contact_email'
            )
                 ->rules('required')
                 ->help(trans('xheetah-nova::help.clients.contact_email'))
                 ->clickable()
                 ->clickableOnIndex(),

            Topic::make(trans('xheetah-nova::topics.clients.integration'))
                 ->withSVG('cog'),

            Text::make(
                trans('xheetah-nova::fields.clients.api_token'),
                'api_token'
            )
                ->rules('required', 'size:15')
                ->hideFromIndex()
                ->onCreateDefault(strtoupper(str_random(15)))
                ->help(trans('xheetah-nova::help.clients.api_token')),

            /*
            HasMany::make(trans('xheetah-nova::fields.deliveries'), 'deliveries', \Waygou\XheetahNova\Resources\Delivery::class),

            */
            HasMany::make(trans('xheetah-nova::resources.cost_centers.plural'), 'costCenters', \Waygou\XheetahNova\Resources\CostCenter::class),

            HasMany::make(trans('xheetah-nova::fields.clientusers'), 'users', \Waygou\XheetahNova\Resources\ClientUser::class),

            MorphMany::make(trans('xheetah-nova::resources.addresses.plural'), 'addresses', \Waygou\XheetahNova\Resources\Address::class),
        ];
    }
}
