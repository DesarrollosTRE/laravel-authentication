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
            ->type($this->user->email, 'email')
            ->type($this->user->password, 'password')
            ->press(trans('authentication::session.create'))
            ->seePageIs(config('authentication.login.redirectUri'));
    }

    public function testInvalidLoginAttempt()
    {
        $this->visit(route('authentication::session.create'))
            ->type('non@existing.user', 'email')
            ->type('invalid-password', 'password')
            ->press(trans('authentication::session.create'))
            ->see(trans('authentication::session.creation_failed'));
    }

}
