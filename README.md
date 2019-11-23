<p align="center"><img src="https://res.cloudinary.com/dave24hwj8/image/upload/v1570257749/laravel-compass-logo.svg"></p>

<p align="center">
<a href="https://travis-ci.org/davidhsianturi/laravel-compass"><img src="https://travis-ci.org/davidhsianturi/laravel-compass.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/davidhsianturi/laravel-compass"><img src="https://poser.pugx.org/davidhsianturi/laravel-compass/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/davidhsianturi/laravel-compass"><img src="https://poser.pugx.org/davidhsianturi/laravel-compass/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/davidhsianturi/laravel-compass"><img src="https://poser.pugx.org/davidhsianturi/laravel-compass/license.svg" alt="License"></a>
</p>

<p align="center">
<kbd>
<img src="https://res.cloudinary.com/dave24hwj8/image/upload/v1571332039/Screenshot_2019-10-17_at_20.18.43_PM.png">
</kbd>
</p>

## Introduction

Laravel Compass is an elegant REST assistant for the Laravel framework that you can use to test API calls and create API documentation. it provides automatically endpoints for GET, POST, PUT/PATCH, DELETE, various auth mechanisms and other utility endpoints based on Laravel routes in your project.

## Installation

You may use Composer to install Compass into your Laravel project:

``` bash
composer require davidhsianturi/laravel-compass --dev
```

Once Composer is done, publish its assets using the `compass:install` Artisan command.
After installing Compass, you should also run the `migrate` command:

``` bash
php artisan compass:install

php artisan migrate
```

### Updating Compass

When updating Compass, you should re-publish the assets:

```bash
php artisan compass:publish
```

## Migration Customization

If you are not going to use Compass' default migrations, you should call the `Compass::ignoreMigrations` method in the `register` method of your `AppServiceProvider`.
You may export the default migrations using the `php artisan vendor:publish --tag=compass-migrations` command.

## Configuration

After publishing Compass' assets, its primary configuration file will be located at `config/compass.php`

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
```

You can build the API documentation using the `php artisan compass:build` command and go to `yourproject.test/docs/index.html` to see the result.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [David H. Sianturi](https://github.com/davidhsianturi)
- [All Contributors](../../contributors)

The `build` API documentation functionality is heavily inspired by [laravel-apidoc-generator](https://github.com/mpociot/laravel-apidoc-generator) and uses [Documentarian](https://github.com/mpociot/documentarian) package by [Marcel Pociot](https://github.com/mpociot).

## License

Laravel Compass is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
