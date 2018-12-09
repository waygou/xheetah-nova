<?php

return [

    'vehicles' => [
        'registration'      => 'A custom vehicle code',
    ],

    'duration_types' => [
        'next_day_deadline' => 'If this delivery type is requested after the deadline, until when it will be delivered in the next day?',
        'requested_until'   => 'Until when, in the same day, can this duration type service be requested.',
    ],

    'delivery_types' => [
        'client' => 'In case this delivery type have a specific price for a specific client',
    ],

    'deliveries' => [
        'with_return' => 'If checked, it will automatically created a delivery in opposite direction, with the same exact information. You can later edit the delivery before it is assigned to a Courier.',
        'related_address' => 'You can select an address here to pre-fill the address fields below.',
    ],

    'client_users' => [
        'password' => 'You can change your password here.',
    ],

    'couriers' => [
        'password' => 'You can change your password here.',
    ],

    'users' => [
        'password' => 'You can change a user password here. If the user is a Courier, it will automatically disconnect the app mobile for security reasons.',
    ],

    'addresses' => [
        'name' => 'Something easy to remember for this address. E.g. Near Carrefour',
    ],

    'clients' => [
        'contact_email'      => 'An email will be sent to the new User to create a password. Email will be used as username to login on the backoffice',
        'api_token'          => 'Private token key used for all API transactions',
        'name'               => 'Client commercial name',
        'contract_starts_at' => 'Start date where the Client can request deliveries',
        'is_active'          => 'If the status changes, the main contact will be notified by email.',
    ],
];
