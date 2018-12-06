<?php

namespace Waygou\XheetahNova\Resources;

use Inspheric\Fields\Email;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsToMany;
use Waygou\NovaUx\Components\Fields\BelongsTo;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class ClientUser extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Childs\ClientUser::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $searchRelations = [
        'mainRole' => ['name'],
        'client'   => ['name'],
    ];

    public static $search = [
        'name', 'email', 'phone',
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
                ->canSee(function ($request) {
                    return user_is('super-admin');
                }),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            )->rules('required'),

            Email::make(
                trans('xheetah-nova::fields.common.email'),
                'email'
            )->rules('required', 'email')
             ->hideFromIndex()
             ->clickable(),

            Text::make(
                trans('xheetah-nova::fields.common.phone'),
                'phone'
            )
                ->hideFromIndex(),

            /*
             * Password is only shown in case it's:
             * A super-admin, admin, or the own user.
             */
            Password::make(
                trans('xheetah-nova::fields.common.password'),
                'password'
            )
                    ->creationRules('required', 'min:6')
                    ->updateRules('nullable', 'min:6')
                    ->canSee(function ($request) {
                        return user_is(['admin', 'super-admin']) ||
                               $request->user()->id == $this->id;
                    })
                    ->help(trans('xheetah-nova::help.client_user.password'))
                    ->onlyOnForms(),

            Boolean::make(
                trans('xheetah-nova::fields.common.is_active'),
                'is_active'
            )
                   ->canSee(function ($request) {
                       return user_is(['super-admin', 'admin', 'client-admin']);
                   }),

            // Computed field: Does this client user has a client-admin profile code?
            Boolean::make(
                trans('xheetah-nova::fields.common.is_admin'),
                function () {
                    return $this->profiles->pluck('code')->contains('client-admin');
                }
            )->canSee(function ($request) {
                return user_is(['super-admin', 'admin']);
            }),

            BelongsToMany::make(
                trans('xheetah-nova::resources.profiles.plural'),
                'profiles',
                \Waygou\SurveyorNova\Resources\Profile::class
            )
                         ->canSee(function ($request) {
                             return user_is(['super-admin', 'admin']);
                         }),

            BelongsTo::make(
                trans('xheetah-nova::resources.clients.singular'),
                'client',
                \Waygou\XheetahNova\Resources\Client::class
            ),

            // By default the main role is computed in the model observer.
            BelongsTo::make(
                trans('xheetah-nova::fields.client_users.main_role'),
                'mainRole',
                \Waygou\XheetahNova\Resources\MainRole::class
            )
                     ->canSee(function ($request) {
                         return user_is(['super-admin', 'admin']);
                     })
                     ->onlyOnDetail(),
        ];
    }
}
