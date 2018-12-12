<?php

return [

    'common' => [
        'address'       => 'Address',
        'city'          => 'City',
        'client'        => 'Client',
        'code'          => 'Code',
        'comments'      => 'Comments',
        'contact_name'  => 'Contact Name',
        'contact_phone' => 'Contact Phone',
        'contact_email' => 'Contact Email',
        'country'       => 'Country',
        'courier'       => 'Courier',
        'description'   => 'Description',
        'duration'      => 'Duration',
        'email'         => 'E-mail',
        'floor_number'  => 'Floor number',
        'from'          => 'From',
        'license_plate' => 'License Plate',
        'locality'      => 'Locality',
        'is_active'     => 'Is Active',
        'is_admin'      => 'Is Admin',
        'map'           => 'Map',
        'name'          => 'Name',
        'password'      => 'Password',
        'phone'         => 'Phone',
        'postal_code'   => 'Postal Code',
        'registration'  => 'Registration',
        'since'         => 'Since',
        'status'        => 'Status',
        'to'            => 'To',
        'vehicle'       => 'Vehicle',
    ],

    'duration_types' => [
        'requested_until'   => 'Requested Until',
        'time_type'         => 'Time Type',
        'next_day_deadline' => 'Next Day Deadline',
    ],

    'vehicles' => [
        'brandmodel' => 'Brand / Model',
        'type'       => 'Type',
    ],

    'clients' => [
        'social_designation' => 'Legal Name',
        'contract_starts_at' => 'Contract Start Date',
        'fiscal_number'      => 'Fiscal Number',
        'contact_name'       => 'Contact Name',
        'contact_email'      => 'Contact Email',
        'contact_phone'      => 'Contact Phone',
        'api_token'          => 'API Token',
        'active'             => 'Is Active?',
    ],

    'addresses' => [
        'addressable' => 'Related to ',
    ],

    'client_users' => [
        'main_role' => 'Main Role',
    ],

    'delivery_types' => [
        'duration_type'            => 'Duration Type',
        'vehicle_type'             => 'Vehicle Type',
        'price_request'            => 'Price Request',
        'price_request_additional' => 'Additional Price Request',
        'price_km'                 => 'Price per Km',
        'price_km_additional'      => 'Additional Price per Km',
    ],

    'deliveries'               => [
        'assigned_to'                 => 'Courier',
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
