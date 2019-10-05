<p align="center"><img src="https://res.cloudinary.com/dave24hwj8/image/upload/v1570257749/laravel-compass-logo.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/telescope"><img src="https://travis-ci.org/davidhsianturi/laravel-compass.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/davidhsianturi/laravel-compass"><img src="https://poser.pugx.org/davidhsianturi/laravel-compass/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/davidhsianturi/laravel-compass"><img src="https://poser.pugx.org/davidhsianturi/laravel-compass/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/davidhsianturi/laravel-compass"><img src="https://poser.pugx.org/davidhsianturi/laravel-compass/license.svg" alt="License"></a>
</p>

<p align="center"><b>Laravel REST client for testing API endpoints and build the documentation</b></p>

<p align="center">
<kbd>
<img src="https://res.cloudinary.com/dave24hwj8/image/upload/v1570257669/Screenshot_2019-10-05_at_19.16.20_PM.png">
</kbd>
</p>

## Installation

You may use Composer to install Compass into your Laravel project:

```
composer require davidhsianturi/laravel-compass --dev
```

Once Composer is done, run the following command:

```
php artisan compass:install

php artisan migrate
```

### Updating Compass

When updating Compass, you should re-publish the assets:

```
php artisan compass:publish
```

## License

Laravel Compass is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
