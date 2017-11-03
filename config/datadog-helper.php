<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Datadog Tracking Enabled
    |--------------------------------------------------------------------------
    |
    | Set this option to enable or disable the datadog helper.
    |
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Datadog Tracking Prefix
    |--------------------------------------------------------------------------
    |
    | This is the prefix that will be placed in front of all of your metric entries. If you have multiple
    | applications being tracked in Datadog, it is recommended putting the application name somewhere
    | inside of your prefix. A common naming scheme is something like app.<app-name>.
    |
    */
    'prefix' => 'negarin',

    'api_key' => '57d94275b8409bcb7deeaa4ee978796c',

    'application_key' => '596d346c51e4fe5978df9edaf2888bcf058c36d1',

    'datadog_host' => 'https://app.datadoghq.com',

    'statsd_server' => 'localhost',

    'statsd_port' => 8125,

    /*
    |--------------------------------------------------------------------------
    | Transport
    |--------------------------------------------------------------------------
    |
    | Submitting events via TCP vs UDP
    | TCP - High-confidence event submission. Will log errors on event submission error.
    | UDP - "Fire and forget" event submission. Will not log errors on event submission error.
    | No acknowledgement of submitted event from Datadog.
    | Since the UDP method uses the a local dogstatsd instance you don't need to setup
    | any additional application/api access.
    */
    'transport' => 'TCP'

];
