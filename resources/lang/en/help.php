<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Help Language Lines
    |--------------------------------------------------------------------------
    |
    | //
    */

    'registration'      => 'A custom vehicle code',
    'requested_until'   => 'Until when in the day can this service type be requested?',

    'duration_types' => [
        'next_day_deadline' => 'If this service type is requested after the deadline, until when it will be delivered in the next day?',
        'requested_until' => 'Until when, in the same day, can this duration type service be requested.'
    ],

    'service_types' => [
        'client' => 'In case this service type have a specific price for a specific client',
    ],

    'deliveries' => [
        'registration' => 'A specific code that might be used by the client to refer an internal company reference',
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
    ],
];
