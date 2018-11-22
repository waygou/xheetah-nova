<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\NovaUx\Components\Fields\Textarea;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class CostCenter extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\CostCenter::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name',
    ];

    public static $with = ['client', 'addresses'];

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

            Text::make(trans('xheetah-nova::fields.common.name'), 'name')
                ->rules('required'),

            Text::make(trans('xheetah-nova::fields.common.contact_name'), 'contact_name')
                ->hideFromIndex(),

            Text::make(trans('xheetah-nova::fields.common.contact_phone'), 'contact_phone')
                ->hideFromIndex(),

            Email::make(trans('xheetah-nova::fields.common.contact_email'), 'contact_email')
                 ->clickable(),

            Textarea::make(trans('xheetah-nova::fields.common.comments'), 'comments')
                ->hideFromIndex(),

            Boolean::make(trans('xheetah-nova::fields.common.is_active'), 'is_active')
                   ->onlyOnForms(),

            BelongsTo::make(trans('xheetah-nova::resources.clients.singular'), 'client', \Waygou\XheetahNova\Resources\Client::class),

            MorphMany::make(trans('xheetah-nova::resources.addresses.plural'), 'addresses', \Waygou\XheetahNova\Resources\Address::class),
        ];
    }
}
