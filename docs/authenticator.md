# Authenticator

Compass authenticator using [Laravel authentication](https://laravel.com/docs/7.x/authentication) guard driver to gather all the `credentials` of users automatically that can be used to perform auth requests through the UI.

Currently, Compass ships with a simple based [Token](https://laravel.com/docs/6.x/api-authentication) guard driver and [Laravel Sanctum](https://laravel.com/docs/7.x/sanctum) guard driver; however, writing custom driver is simple and you are free to extend Compass Authenticator with your own guard implementations.

You should enable Compass authenticator using the `enabled` configuration option:

```php
'authenticator' => [
    'enabled' => true,
    'guard' => 'sanctum',
    ...
],
```

and you may adjust the authentication guard driver for your application to support `token` or `sanctum`.

### Custom Driver

if one of the built-in Compass Authenticator guard driver doesn't fit your needs, you may write your own custom driver and register it with Compass. 

#### Writing The Driver

Your driver should implements the `Davidhsianturi\Compass\Contracts\AuthenticatorRepository` interface class. This interface class contains only one method your custom driver must implement:

```php
use Davidhsianturi\Compass\Contracts\AuthenticatorRepository;

class JwtAuthenticator implements AuthenticatorRepository
{
    /**
     * Return a valid credential of users.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\Authenticators\CredentialResult[]
     */
    public function credentials()
    {
        ...
    }
}
```

You may find it helpful to review the implementations of `credentials` method on the `Davidhsianturi\Compass\Authenticators\SanctumAuth` class. This class will provide you with a good starting point for learning how to implement the method in your own driver.


#### Registering The Driver

Once you have written your custom driver, you may register it with Compass using the `extend` method of the Compass authenticator. You should call the `extend` method from the `register` method of your `AppServiceProvider` or any other service provider used by your application. For example, if you have written a `JwtAuthenticator`, you may register it like so:

```php
use Davidhsianturi\Compass\Authenticator;

/**
* Register any application services.
*
* @return void
*/
public function register()
{
    if ($this->app->environment('local')) {
        $authenticator = $this->app->make(Authenticator::class);
        $authenticator->extend('jwt', function () use ($authenticator) {
            return new JwtAuthenticator($authenticator->getConfig());
        });
    }
}
```

Once your driver has been registered, you may specify it as your default Compass authenticator guard in your `config/compass.php` configuration file:

```php
'authenticator' => [
    'enabled' => true,
    'guard' => 'jwt',
    ...
],
```
