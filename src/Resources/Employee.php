<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;
use Waygou\NovaUx\Components\Fields\BelongsTo;

class Employee extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Childs\Employee::class;

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

            Text::make(trans('xheetah-nova::fields.name')),

            Email::make(trans('xheetah-nova::fields.email'))
                 ->clickableOnIndex()
                 ->clickable(),

            Text::make(trans('xheetah-nova::fields.phone')),

            Password::make(trans('xheetah-nova::fields.password'))
                    ->onlyOnForms(),

            Boolean::make(trans('xheetah-nova::fields.is_active'), 'is_active'),

            BelongsToMany::make('Profiles', 'profiles', \Waygou\SurveyorNova\Resources\Profile::class),

            // By default the main role is computed in the courier observer.
            BelongsTo::make('Main Role', 'mainRole', \Waygou\XheetahNova\Resources\MainRole::class)
                     ->onlyOnDetail(),
        ];
    }
}
