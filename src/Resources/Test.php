<?php

namespace Waygou\XheetahNova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Waygou\Xheetah\Models\Address;
use Waygou\XheetahNova\Abstracts\XheetahResource;
use Waygou\XheetahNovaUI\Components\Fields\BelongsTo;
use Waygou\XheetahNovaUI\Components\Fields\Text;
use Waygou\XheetahNovaUI\Components\Fields\Topic;

class Test extends XheetahResource
{
    public static $model = \Waygou\Xheetah\Models\Test::class;

    public static $title = 'name';

    public static $displayInNavigation = true;

    public static $search = [
        'name', 'hints',
    ];

    public static $with = ['client', 'address'];

    public static function group()
    {
        return trans('xheetah-nova::sidebar.other');
    }

    public function subtitle()
    {
        return "{$this->name} {$this->hints}";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Topic::make('Personal Information')
                  ->withSVG('icon-user'),

            Text::make('Name', 'name')
                ->placeholder('Make my day'),

            Text::make('Hints', 'hints')
                  ->affectedBy('name', function ($value) {
                      return response()->json(['value' => 'Martirizante!']);
                  }),

            BelongsTo::make('Client', 'client', \Waygou\XheetahNova\Resources\Client::class)
                     ->searchable(),

            /*
            Select::make('Pre-loaded Address', 'address_id')
                  ->displayUsing(function ($value) {
                      return !is_null($value) ?
                                Address::where('id', $value)->first()->address_line_1 :
                                null;
                  })
                  ->options([])
                  ->affectedBy('client', function ($value) {
                      return response()->json(AddressRestriction::restrictToClient($value));
                  }),
            */
            //Place::make('Address', 'address_line_1'),

            /*
            Text::make('Postal Code', 'postal_code'),

            Text::make('Locality', 'locality'),

            /*
            Text::make('City', 'city')
                  ->displayUsing(function ($name) {
                      return $name.' - Fire on the hole';
                  })
                ->hidden(),

            Text::make('Country', 'country'),

            Text::make('Country Code', 'country_code')
                ->hidden(),

            Text::make('Latitude/Longitude', 'lat_lng')
                ->hidden(),
            */
        ];
    }
}
