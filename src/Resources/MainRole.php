<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class MainRole extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\MainRole::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'id', 'name',
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
              ->onlyOnForms(),

            Text::make(trans('xheetah-nova::fields.common.name'), 'name'),
            Text::make(trans('xheetah-nova::fields.common.code'), 'code'),

            HasMany::make(trans('xheetah-nova::resources.users.plural'), 'users', \Waygou\XheetahNova\Resources\User::class),
        ];
    }
}
