<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fields Language Lines
    |--------------------------------------------------------------------------
    |
    | //
    */

    /*
    'name'                     => 'Name',
    'email'                    => 'Email',
    'phone'                    => 'Phone',
    'password'                 => 'Password',
    'is_active'                => 'Is active?',
    'roles'                    => 'Roles',
    'permissions'              => 'Permissions',
    'fiscal_number'            => 'Fiscal number',
    'code'                     => 'Code',
    'contracted_at'            => 'Contracted at',
    'social_name'              => 'Social designation',
    'contact_name'             => 'Contact name',
    'contact_phone'            => 'Contact phone',
    'contact_email'            => 'Contact email',
    'notes'                    => 'Notes',
    'is_admin'                 => 'Is admin?',
    'brandmodel'               => 'Brand and model',
    'since'                    => 'Since',
    'registration'             => 'Registration',
    'license_plate'            => 'License plate',
    'description'              => 'Description',
    'duration'                 => 'Duration',
    'duration_type'            => 'Duration type',
    'next_day_deadline'        => 'Next day deadline',
    'requested_until'          => 'Requested until',
    'addressable'              => 'Addressable',
    'profiles'                 => 'Profiles',
    'main_role'                => 'Main Role',
    'client'                   => 'Client',
    'vehicle'                  => 'Vehicle',
    'vehicle_type'             => 'Vehicle Type',
    'time_type'                => 'Time Type',
    'vehicles'                 => 'Vehicles',
    'assigned_to'              => 'Assigned to',
    'price_request'            => 'Price (request)',
    'price_request_additional' => 'Price (request, additional)',
    'price_km'                 => 'Price (km)',
    'price_km_additional'      => 'Price (km, additional)',
    'service_types'            => 'Service Types',
    'cost_center'              => 'Cost Center',
    'cost_centers'             => 'Cost Centers',
    'client_users'             => 'Client Users',
    'client_user'              => 'Client User',
    'service_type'             => 'Service Type',
    'delivery'                 => 'Delivery',
    'costcenter'               => 'Cost Center',
    'clientuser'               => 'Client User',
    'clientusers'              => 'Client Users',
    'deliveries'               => 'Deliveries',
    'costcenters'              => 'Cost Centers',
    'clientusers'              => 'Client Users',
    'courier'                  => 'Courier',
    'client_addresses'         => 'Client Addresses',
    'cost_center_addresses'    => 'Cost Center Addresses',
    'preloaded_addresses'      => 'Pre-loaded Addresses',
    'address'                  => 'Address',
    'postal_code'              => 'Postal Code',
    'city'                     => 'City',
    'locality'                 => 'Locality',
    'country_code'             => 'Country Code',
    'lat_lng'                  => 'Latitude / Longitude',
    'country'                  => 'Country',
    'map'                      => 'Map',
    'api_token'                => 'Token API',
    */

    'common' => [
        'address'       => 'Address',
        'city'          => 'City',
        'courier'       => 'Courier',
        'comments'      => 'Comments',
        'contact_name'  => 'Contact Name',
        'contact_phone' => 'Contact Phone',
        'contact_email' => 'Contact Email',
        'country'       => 'Country',
        'floor_number'  => 'Floor number',
        'license_plate' => 'License Plate',
        'locality'      => 'Locality',
        'is_active'     => 'Is Active',
        'map'           => 'Map',
        'name'          => 'Name',
        'postal_code'   => 'Postal Code',
        'registration'  => 'Registration',
        'since'         => 'Since'
    ],

    'vehicles' => [
        'brandmodel' => 'Brand / Model',
        'type' => 'Type'
    ],

    'clients' => [
        'social_designation' => 'Legal Name',
        'contract_starts_at' => 'Contract Start Date',
        'fiscal_number'      => 'Fiscal Number',
        'contact_name'       => 'Contact Name',
        'contact_email'      => 'Contact Email',
        'contact_phone'      => 'Contact Phone',
        'api_token'          => 'API Token',
        'active'             => 'Is Active?'
    ],

    'addresses' => [
        'addressable' => 'Related to ',

    ],

    'costcenters' => [
        '',
    ],

    'deliveries'               => [
        'client'                      => 'Client',
        'cost_center'                 => 'Cost Center',
        'notes'                       => 'Notes',
        'postal_code'                 => 'Postal Code',
        'city'                        => 'City',
        'locality'                    => 'Locality',
        'country'                     => 'Country',
        'address_location'            => 'Address Location',
        'origin_related_address'      => 'Origin Address',
        'destination_related_address' => 'Destination Address',
        'address'                     => 'Address',
        'created_by'                  => 'Created by',
        'delivery_type'               => 'Delivery Type',
        'with_return'                 => 'With return?',
        'merchandise_description'     => 'Merchandise Description',
        'volumes_qty'                 => 'Volumes Quantity',
        'volumes_total_weight'        => 'Volumes Total Weight',
        'price_request'               => 'Price to Request at Pick-up',
        'schedule_type'               => 'Schedule Type',
        'schedule_planned_at'         => 'Schedule Planned At',
        'comments_courier'            => 'Comments made by Courier',
        'comments_internal'           => 'Comments made internally',
    ],
];
