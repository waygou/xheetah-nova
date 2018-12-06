<?php

namespace Waygou\XheetahNova\Resources;

use Inspheric\Fields\Email;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
use Waygou\NovaUx\Components\Fields\Topic;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class Client extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Client::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name', 'fiscal_number', 'contact_name',
    ];

    public static $with = ['users',
                           'costCenters',
                           'addresses',
                           'deliveries', ];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.entities');
    }

    public function subtitle()
    {
        return "{$this->contact_name} {$this->fiscal_number}";
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
                trans('xheetah-nova::topics.clients.identification')
            )->withSVG('folder-outline'),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            )->rules('required')
             ->help(trans('xheetah-nova::help.clients.name')),

            Text::make(
                trans('xheetah-nova::fields.clients.social_designation'),
                'social_name'
            )->rules('required')
             ->onlyOnForms(),

            Date::make(
                trans('xheetah-nova::fields.clients.contract_starts_at'),
                'contract_start'
            )->help(trans('xheetah-nova::help.clients.contract_starts_at'))
             ->rules('required')
             ->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.clients.fiscal_number'),
                'fiscal_number'
            )->onlyOnForms(),

            Boolean::make(
                trans('xheetah-nova::fields.clients.active'),
                'is_active'
            )->help(trans('xheetah-nova::help.clients.is_active'))
            ->canSee(function ($request) {
                return user_is(['super-admin', 'admin', 'client-admin']);
            })->hideFromIndex(),

            Topic::make(trans('xheetah-nova::topics.clients.contact_admin'))
                 ->withSVG('user'),

            Text::make(
                trans('xheetah-nova::fields.clients.contact_name'),
                'contact_name'
            )->rules('required')
             ->hideFromIndex(),

            Text::make(
                trans('xheetah-nova::fields.clients.contact_phone'),
                'contact_phone'
            )->hideFromIndex(),

            Email::make(
                trans('xheetah-nova::fields.common.email'),
                'contact_email'
            )->clickableOnIndex()
             ->clickable()
             ->sortable()
             ->creationRules('unique:tenant.users,email', 'required', 'email')
             ->updateRules('unique:tenant.users,email,{{resourceId}}', 'required', 'email')
             ->onlyOnForms(),

            Topic::make(trans('xheetah-nova::topics.clients.integration'))
                 ->onlyOnDetail()
                 ->withSVG('cog'),

            Text::make(
                trans('xheetah-nova::fields.clients.api_token'),
                'api_token'
            )->onlyOnDetail()
             ->canSee(function ($request) {
                 return user_is(['super-admin', 'admin', 'client-admin']);
             })
             ->help(trans('xheetah-nova::help.clients.api_token')),

            HasMany::make(
                trans('xheetah-nova::resources.cost_centers.plural'),
                'costCenters',
                \Waygou\XheetahNova\Resources\CostCenter::class
            ),

            HasMany::make(
                trans('xheetah-nova::resources.client_users.plural'),
                'users',
                \Waygou\XheetahNova\Resources\ClientUser::class
            ),

            MorphMany::make(
                trans('xheetah-nova::resources.addresses.plural'),
                'addresses',
                \Waygou\XheetahNova\Resources\Address::class
            ),

            HasMany::make(
                trans('xheetah-nova::resources.deliveries.plural'),
                'deliveries',
                \Waygou\XheetahNova\Resources\Delivery::class
            ),
        ];
    }
}
