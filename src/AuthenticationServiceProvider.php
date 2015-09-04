<?php namespace Speelpenning\Authentication;

use Illuminate\Support\ServiceProvider;
use Speelpenning\Authentication\Repositories\PasswordResetRepository;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Contracts\Authentication\CanRegister;
use Speelpenning\Contracts\Authentication\ExpirableToken;
use Speelpenning\Contracts\Authentication\Repositories\PasswordResetRepository as PasswordResetRepositoryContract;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository as UserRepositoryContract;

class AuthenticationServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (config('authentication.enableRoutes') and ! $this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'authentication');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'authentication');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/authentication.php', 'authentication');

        $this->app->singleton(PasswordResetRepositoryContract::class, function ($app) {
            return new PasswordResetRepository($app['config']);
        });

        $this->app->singleton(UserRepositoryContract::class, function ($app) {
            return new UserRepository();
        });
    }
}
