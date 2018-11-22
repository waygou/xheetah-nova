<?php

namespace Waygou\XheetahNova\Traits;

use Laravel\Nova\Fields\Country;
use Waygou\NovaUx\Components\Fields\Map;
use Waygou\NovaUx\Components\Fields\Text;

trait FieldGroups
{
    // Computes the field attribute in case there is a specific field attribute
    // name passed, or a prefix.
    private function getFieldAttribute($field, $fields = null, $prefix = null)
    {
        if (is_null($fields)) {
            $fields = [];
        }

        if (array_key_exists($field, $fields)) {
            $field = $fields[$field];
        }

        return is_null($prefix) ? $field : "{$prefix}_{$field}";
    }

    // Loads up address fields array keys (defaults):
    // address
    // city
    // locality
    // postal_code
    // country_code
    // lat_lng
    // country

    /**
     * Loads up address fields.
     *
     * @param array  $fields The fields array (address, city, locality, postal_code,
     *                       country, country_code, lat_lng, country, map)
     * @param string $prefix A prefix to be given to the fields.
     *
     * @return array The fields to load on the form/index/detail.
     */
    protected function addressFields($fields = null, $prefix = null)
    {
        return $this->merge([

            Address::make(
                trans('xheetah-nova::fields.address'),
                $this->getFieldAttribute('address', $fields, $prefix)
            )
                ->postalCode($this->getFieldAttribute('postal_code', $fields, $prefix))
                ->city($this->getFieldAttribute('city', $fields, $prefix))
                ->locality($this->getFieldAttribute('locality', $fields, $prefix))
                ->countryCode($this->getFieldAttribute('country_code', $fields, $prefix))
                ->latLng($this->getFieldAttribute('lat_lng', $fields, $prefix))
                ->country($this->getFieldAttribute('country', $fields, $prefix))
                ->map($this->getFieldAttribute('map', $fields, $prefix)),

            Text::make(
                trans('xheetah-nova::fields.postal_code'),
                $this->getFieldAttribute('postal_code', $fields, $prefix)
            ),

            Text::make(
                trans('xheetah-nova::fields.city'),
                $this->getFieldAttribute('city', $fields, $prefix)
            ),

            Text::make(
                trans('xheetah-nova::fields.locality'),
                $this->getFieldAttribute('locality', $fields, $prefix)
            ),

            Country::make(
                trans('xheetah-nova::fields.country_code'),
                $this->getFieldAttribute('country_code', $fields, $prefix)
            ),

            Text::make(
                trans('xheetah-nova::fields.lat_lng'),
                $this->getFieldAttribute('lat_lng', $fields, $prefix)
            ),

            Text::make(
                trans('xheetah-nova::fields.country'),
                $this->getFieldAttribute('country', $fields, $prefix)
            ),

            Map::make(
                trans('xheetah-nova::fields.map'),
                $this->getFieldAttribute('map', $fields, $prefix)
            )
            ->affectedBy(
                $this->getFieldAttribute('lat_lng', $fields, $prefix),
                'Waygou\Xheetah\Restrictions\AddressRestriction@loadLatLng'
            ),
        ]);
    }
}
