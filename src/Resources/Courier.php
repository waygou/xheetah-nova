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

class Courier extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Childs\Courier::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'id', 'name', 'email', 'phone',
    ];

    public static $searchRelations = [
        'mainRole' => ['name'],
        'vehicle'  => ['name'],
    ];

    public static $with = ['mainRole', 'profiles', 'vehicle'];

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

            Text::make(xheetah_trans('fields.name'))
                ->rules('required', 'max:191'),

            Email::make(xheetah_trans('fields.email'))
                 ->creationRules('unique:users,email', 'max:191')
                 ->updateRules('unique:users,email,{{resourceId}}')
                 ->onlyOnForms()
                 ->clickable(),

            Password::make(xheetah_trans('fields.password'))
                    ->creationRules('required', 'min:6')
                    ->updateRules('nullable', 'min:6')
                    ->onlyOnForms(),

            Text::make(xheetah_trans('fields.phone'))
                ->onlyOnForms(),

            Boolean::make(xheetah_trans('fields.is_active'), 'is_active')
                   ->rules('required'),

            BelongsToMany::make(
                trans('xheetah-nova::fields.profiles'),
                'profiles',
                \Waygou\SurveyorNova\Resources\Profile::class
            )->onlyOnDetail(),

            // By default the main role is computed in the courier observer.
            BelongsTo::make(
                trans('xheetah-nova::fields.main_role'),
                'mainRole',
                \Waygou\XheetahNova\Resources\MainRole::class
            )->rules('required')
             ->hideFromIndex(),

            BelongsTo::make(
                trans('xheetah-nova::fields.vehicle'),
                'vehicle',
                \Waygou\XheetahNova\Resources\Vehicle::class
            )->hideFromIndex(),
        ];
    }
}
