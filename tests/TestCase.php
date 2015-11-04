<?php

use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Speelpenning\Authentication\AuthenticationServiceProvider;
use Speelpenning\Authentication\User;

abstract class TestCase extends LaravelTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $this->configureLaravel();

        $app->register(AuthenticationServiceProvider::class);

        return $app;
    }

    protected function configureLaravel()
    {
        config([
            'auth.model' => User::class,
            'authentication.enableRoutes' => true,
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'mail.pretend' => true,
        ]);
    }
}
