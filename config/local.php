<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Local Config file
    |--------------------------------------------------------------------------
    | This file contains configuration specific for this host only.
    */

    /*
    |--------------------------------------------------------------------------
    | host_type
    |--------------------------------------------------------------------------
    | The value of host_type variable can only be central or node.
    */

    'host_type' => env('HOST_TYPE', 'central'),


    /*
    |--------------------------------------------------------------------------
    | app_pgw_sandbox
    |--------------------------------------------------------------------------
    | Is payment gateway in sandbox mode
    */

    'is_sandbox_pgw' => env('IS_SANDBOX_PGW', true),

    /*
    |--------------------------------------------------------------------------
    | curlopt_ssl_verifypeer
    |--------------------------------------------------------------------------
    | Verify peer in curlopt request
    */
    'curlopt_ssl_verifypeer' => env('CURLOPT_SSL_VERIFYPEER', false),

    /*
    |--------------------------------------------------------------------------
    | curlopt_ssl_verifyhost
    |--------------------------------------------------------------------------
    | Verify peer in curlopt request
    */
    'curlopt_ssl_verifyhost' => env('CURLOPT_SSL_VERIFYHOST', false),

    /*
    |--------------------------------------------------------------------------
    | radius_cache_store
    |--------------------------------------------------------------------------
    | radius cache store for localhost
    */
    'radius_cache_store' => env('RADIUS_CACHE_STORE', 'file'),

];
