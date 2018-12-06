<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Waygou\NovaUx\Components\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class MainRole extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\MainRole::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name',
    ];

    public static $with = ['users'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
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
            ),

            HasMany::make(
                trans('xheetah-nova::resources.users.plural'),
                'users',
                \Waygou\XheetahNova\Resources\User::class
            ),
        ];
    }
}
