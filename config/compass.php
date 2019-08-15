<?php

return [
    // This is the URI path where Compass will be accessible from.
    'path' => env('COMPASS_PATH', 'compass'),

    // The routes should be listed for the endpoint.
    'routes' => [
        'domains' => [
            '*',
            // 'domain.*',
        ],

        'prefixes' => [
            '*',
            // 'prefix/*',
        ],

        // exclude routes by name
        'exclude' => [
            'compass.*',
        ],
    ],

    // Compass storage driver.
    'driver' => env('COMPASS_DRIVER', 'database'),

    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
    ]
];
