<?php

namespace Waygou\XheetahNova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laraning\NovaTimeField\TimeField;
use Waygou\XheetahNova\Abstracts\XheetahResource;

class DurationType extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\DurationType::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name', 'description',
    ];

    public static $with = [];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.system');
    }

    public function subtitle()
    {
        return "{$this->description}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->onlyOnForms(),

            Text::make(
                trans('xheetah-nova::fields.common.name'),
                'name'
            ),

            Text::make(
                trans('xheetah-nova::fields.common.description'),
                'description'
            ),

            TimeField::make(
                trans('xheetah-nova::fields.duration_types.requested_until'),
                'requested_until'
            )
                     ->help(trans('xheetah-nova::help.duration_types.requested_until')),

            Text::make(
                trans('xheetah-nova::fields.common.duration'),
                'duration'
            ),

            Select::make(
                trans('xheetah-nova::fields.duration_types.time_type'),
                'time_type'
            )->options([
                'H' => 'Hours',
                'M' => 'Minutes',
                'D' => 'Days',
                ])->displayUsingLabels(),

            TimeField::make(
                trans('xheetah-nova::fields.duration_types.next_day_deadline'),
                'next_day_deadline'
            )
            ->help(trans('xheetah-nova::help.duration_types.next_day_deadline')),

            HasMany::make(
                trans('xheetah-nova::resources.delivery_types.plural'),
                'deliveryTypes',
                \Waygou\XheetahNova\Resources\DeliveryType::class
            ),
        ];
    }
}
