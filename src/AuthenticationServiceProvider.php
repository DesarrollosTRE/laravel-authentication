<?php namespace Speelpenning\Authentication;

use Illuminate\Support\ServiceProvider;

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
    }
}