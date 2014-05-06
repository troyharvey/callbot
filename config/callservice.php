<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default CallService Driver
    |--------------------------------------------------------------------------
    |
    | Supported: "twilio"
    |
    */

    'default' => 'twilio',

    /*
    |--------------------------------------------------------------------------
    | CallService Connections
    |--------------------------------------------------------------------------
    |
    */

    'connections' => [

        'twilio' => [
            'driver' => 'twilio',
            'sid'    => 'ACf197cc3ae4d026ae2159b6b53eac0d00',
            'token' => 'cd489df3b58cad9c9ec3dc50c1940961'
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Default "from" phone number
    |--------------------------------------------------------------------------
    |
    */

    'from' => '5025120678',

    /*
    |--------------------------------------------------------------------------
    | Default timezone for call details
    |--------------------------------------------------------------------------
    |
    */

    'timezone' => 'America/New_York'
];
