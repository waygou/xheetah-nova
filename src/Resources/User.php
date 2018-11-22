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

class User extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\User::class;

    public static $displayInNavigation = true;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'email', 'phone',
    ];

    public static $searchRelations = [
        'mainRole' => ['name'],
        'client'   => ['name'],
    ];

    public static $with = ['client', 'mainRole', 'profiles'];

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
              ->onlyOnForms(),

            Text::make(trans('xheetah-nova::fields.name'))
                ->sortable()
                ->rules('required', 'max:255'),

            Email::make(trans('xheetah-nova::fields.email'))
                ->clickableOnIndex()
                ->clickable()
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:users,email', 'max:255')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make(trans('xheetah-nova::fields.phone'))
                ->rules('max:20'),

            Password::make(trans('xheetah-nova::fields.password'))
                    ->onlyOnForms()
                    ->creationRules('required', 'min:6'),

            Boolean::make(trans('xheetah-nova::fields.is_active'), 'is_active'),

            BelongsToMany::make('Profiles', 'profiles', \Waygou\SurveyorNova\Resources\Profile::class),
            BelongsTo::make('Client', 'client', \Waygou\XheetahNova\Resources\Client::class),
            BelongsTo::make('Main Role', 'mainRole', \Waygou\XheetahNova\Resources\MainRole::class),
        ];
    }
}
