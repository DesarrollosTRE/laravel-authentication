<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\User;

class SessionControllerTest extends TestCase {

    use DispatchesJobs;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $this->user = User::register('John Doe', 'john.doe@example.com', 'some-password');

        $this->dispatchFrom(RegisterUser::class, $this->user);
    }

    public function testDefaultLoginPage()
    {
        $this->visit(route('authentication::session.create'))
            ->see(trans('authentication::session.create'))
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::user.password'));
    }

    public function testValidLoginAttempt()
    {
        $this->visit(route('authentication::session.create'))
            ->type('john.doe@example.com', 'email')
            ->type('some-password', 'password')
            ->press(trans('authentication::session.create'))
            ->seePageIs(config('authentication.login.redirectUri'));
    }

}
