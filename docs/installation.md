# Installation

Laravel Compass require **PHP 7.2 or higher** and **Laravel 6.0 or higher**.
You may use Composer to install Compass into your Laravel project:

```bash
composer require davidhsianturi/laravel-compass --dev
```

Once Composer is done, publish its assets using the `compass:install` Artisan command. After installing Compass, you should also run the `migrate` command:

```bash
php artisan compass:install

php artisan migrate
```

That's it! Next, you should be able to visit the Compass UI at `yourproject.test/compass` in your browser.

### Updating Compass

When updating Compass, you should re-publish the assets:

```bash
php artisan compass:publish
```
