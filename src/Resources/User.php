<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class User extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\User::class;

    public static $displayInNavigation = true;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'email', 'phone',
    ];

    public static $searchRelations = [
        'mainRole'  => ['name'],
        'client'    => ['name'],
        'vehicle'   => ['vehicle'],
    ];

    public static $with = ['client', 'vehicle', 'mainRole', 'profiles'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
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
              ->canSee(function ($request) {
                  return user_is('super-admin');
              }),

            Text::make(trans('xheetah-nova::fields.common.name'), 'name')
                ->sortable()
                ->rules('required', 'max:191'),

            Email::make(
                trans('xheetah-nova::fields.common.email'),
                'email'
            )
                ->clickableOnIndex()
                ->clickable()
                ->sortable()
                ->creationRules('unique:tenant.users,email', 'max:191')
                ->updateRules('unique:tenant.users,email,{{resourceId}}')
                ->hideFromIndex(),

            Password::make(trans('xheetah-nova::fields.common.password'), 'password')
                    ->creationRules('required', 'min:6')
                    ->updateRules('nullable', 'min:6')
                    ->canSee(function ($request) {
                        return user_is(['admin', 'super-admin']) ||
                               $request->user()->id == $this->id;
                    })
                    ->help(trans('xheetah-nova::help.users.password'))
                    ->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.common.phone'),
                'phone'
            )->hideFromIndex(),

            Boolean::make(trans('xheetah-nova::fields.common.is_active'), 'is_active')
                    ->canSee(function ($request) {
                        return user_is(['admin', 'super-admin']);
                    })
                   ->rules('required'),

            BelongsToMany::make(
                trans('xheetah-nova::resources.profiles.plural'),
                'profiles',
                \Waygou\SurveyorNova\Resources\Profile::class
            ),

            BelongsTo::make(
                trans('xheetah-nova::resources.clients.singular'),
                'client',
                \Waygou\XheetahNova\Resources\Client::class
            ),

            BelongsTo::make(
                trans('xheetah-nova::resources.vehicles.singular'),
                'vehicle',
                \Waygou\XheetahNova\Resources\Vehicle::class
            )->nullable(),

            // By default the main role is computed in the courier observer.
            BelongsTo::make(
                trans('xheetah-nova::resources.main_roles.singular'),
                'mainRole',
                \Waygou\XheetahNova\Resources\MainRole::class
            ),
        ];
    }
}
