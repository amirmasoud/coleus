<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sonic Configuration
    |--------------------------------------------------------------------------
    */

    'sonic' => [
        'address' => env('SONIC_ADDRESS', 'localhost'),
        'port' => env('SONIC_PORT', 1491),
        'password' => env('SONIC_PASSWORD'),
        'connection_timeout' => env('SONIC_CONNECTION_TIMEOUT', 10),
        'read_timeout' => env('SONIC_READ_TIMEOUT',  5)
    ],

];
