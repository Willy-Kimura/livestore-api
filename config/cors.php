<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['/*', 'api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://arumik.co.ke',
        'https://meneja.arumik.co.ke',
        'https://admin.tshanic.co.ke',
        'https://tshanic.co.ke',
        'http://localhost:5173',
        'http://192.168.0.29:5173',
        'http://10.203.109.122:5173',
        'http://10.111.78.122:5173',
        'http://10.118.77.122:5173',
        'http://10.175.102.122:5173',
        'http://10.249.105.122:5173',
        'http://10.25.105.122:5173',
        'http://10.60.70.122:5173',
        'http://10.108.71.122:5173',
        'http://10.108.71.122:5174',
        'http://10.119.209.122:5173',
        'http://10.180.168.122:5173'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
