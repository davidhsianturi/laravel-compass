<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Compass Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Compass will be accessible from. Feel free
    | to change this path to anything you like.
    |
    */

    'path' => env('COMPASS_PATH', 'compass'),

    /*
    |--------------------------------------------------------------------------
    | Laravel Routes
    |--------------------------------------------------------------------------
    |
    | This is the routes rules that will be filtered for the requests list.
    | use "*" as a wildcard to match any characters. note that the following
    | array list "exclude" can be referenced by the route name or route URI.
    | "base_uri" is a string value as a comparison for grouping the routes.
    |
    */

    'routes' => [
        'domains' => [
            '*',
        ],

        'prefixes' => [
            '*',
        ],

        'exclude' => [
            'compass.*',
            'debugbar.*',
            '_ignition/*',
            'telescope/*',
        ],

        'base_uri' => '*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Compass Storage Driver
    |--------------------------------------------------------------------------
    |
    | This configuration options determines the storage driver that will
    | be used to store your API calls and routes. In addition, you may set any
    | custom options as needed by the particular driver you choose.
    |
    */

    'driver' => env('COMPASS_DRIVER', 'database'),

    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Documentation Builder
    |--------------------------------------------------------------------------
    |
    | Compass will write and build contents in Documentarian markdown files
    | and as a generator to generate the API documentation which is a
    | PHP port of the popular Slate API documentation tool.
    |
    | @see https://github.com/mpociot/documentarian
    |
    */

    'builder' => 'slate',

    'template' => [
        'slate' => [
            'output' => 'public/docs',
            'example_requests' => [
                'bash',
            ],
        ],
    ],
];
