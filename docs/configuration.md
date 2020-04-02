# Configuration

After publishing Compass's assets, its primary configuration file will be located at `config/compass.php` below is the default content of the config file:

```php
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
    | This is the routes rules that will be filtered for the requests list. use
    | * as a wildcard to match any characters. note that the following array
    | list "exclude" must be referenced by the route name.
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
    | Compass Authenticator
    |--------------------------------------------------------------------------
    |
    | This options allow you to get all the "credentials" of users that you can
    | use to perform auth requests through the UI. when "enabled" set to "true"
    | you should adjust the authentication guard driver for your application to
    | support "token" or "sanctum".
    |
    */

    'authenticator' => [
        'enabled' => false,
        'guard' => 'api',
        'identifier' => 'email',
    ],

    /*
    |--------------------------------------------------------------------------
    | Compass Documenter Provider
    |--------------------------------------------------------------------------
    |
    | This configuration option determines the documenter provider that will be
    | used to create a beautiful API documentation. In addition, you may set
    | any custom options as needed by the particular provider you choose.
    |
    */

    'documenter' => 'documentarian',

    'provider' => [
        'documentarian' => [
            'output' => 'public/docs',
            'example_requests' => [
                'bash',
            ],
        ],
    ],
];
```

## Migration Customization

If you are not going to use Compass's default migrations, you should call the `Compass::ignoreMigrations` method in the `register` method of your `AppServiceProvider`.
You may export the default migrations using the `php artisan vendor:publish --tag=compass-migrations` command.
