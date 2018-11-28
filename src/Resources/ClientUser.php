<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class ClientUser extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Childs\ClientUser::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'id', 'name', 'email', 'phone',
    ];

    public static $with = ['client', 'mainRole', 'profiles'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.entities');
    }

    public function subtitle()
    {
        return "{$this->phone} {$this->email}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable()
              ->onlyOnForms(),

            Text::make(trans('xheetah-nova::fields.common.name'), 'name'),

            Email::make(trans('xheetah-nova::fields.common.email'), 'email')
                 ->hideFromIndex()
                 ->clickable(),

            Text::make(trans('xheetah-nova::fields.common.phone'), 'phone')
                ->hideFromIndex(),

            Password::make(trans('xheetah-nova::fields.common.password'), 'password')
                    ->onlyOnForms(),

            Boolean::make(trans('xheetah-nova::fields.common.is_active'), 'is_active'),

            // Computed field: Does this client user has a client-admin profile code?
            Boolean::make(trans('xheetah-nova::fields.common.is_admin'), function () {
                return $this->profiles->pluck('code')->contains('client-admin');
            }),

            BelongsToMany::make(trans('xheetah-nova::fields.profiles'), 'profiles', \Waygou\SurveyorNova\Resources\Profile::class),

            BelongsTo::make(trans('xheetah-nova::resources.clients.singular'), 'client', \Waygou\XheetahNova\Resources\Client::class)
                     ->searchable(),

            // By default the main role is computed in the model observer.
            BelongsTo::make(trans('xheetah-nova::fields.main_role'), 'mainRole', \Waygou\XheetahNova\Resources\MainRole::class)
                     ->onlyOnDetail(),
        ];
    }
}
