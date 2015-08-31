<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\User;

class ProfileControllerTest extends TestCase {

    use DispatchesJobs;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $this->user = User::register('John Doe', 'john.doe@example.com', 'some-password');

        $this->dispatchFrom(RegisterUser::class, $this->user);
    }

    protected function login()
    {
        Auth::login($this->user);
    }

    public function testItRequiresAuthentication()
    {
        $this->visit(route('authentication::user.show'))
            ->seePageIs(route('authentication::session.create'));
    }

    public function testProfileCanBeViewedIfAuthenticated()
    {
        $this->login();

        $this->visit(route('authentication::user.show'))
            ->seePageIs(route('authentication::user.show'))
            ->see(trans('authentication::user.name'))
            ->see($this->user->name)
            ->see(trans('authentication::user.email'))
            ->see($this->user->email)
            ->see(trans('authentication::user.edit'));
    }

}
