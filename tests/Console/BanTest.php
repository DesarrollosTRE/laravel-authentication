<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Artisan;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class BanTest extends TestCase
{
    use DispatchesJobs;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('vendor:publish');
        $this->artisan('migrate:refresh');

        $this->dispatchFrom(RegisterUser::class, User::register('John Doe', 'john.doe@example.com', 'some-password'));
        $this->user = app(UserRepository::class)->findByEmailAddress('john.doe@example.com');
    }

    public function testBanning()
    {
        $this->artisan('user:ban', ['email' => $this->user->email]);
        $this->assertContains("User {$this->user->email} is banned and cannot log in anymore.", Artisan::output());
    }

    public function testUnbanning()
    {
        $this->artisan('user:ban', ['email' => $this->user->email, '--unban' => true]);
        $this->assertContains("User {$this->user->email} is unbanned and may log in again.", Artisan::output());
    }

    public function testUserMustExist()
    {
        $this->artisan('user:ban', ['email' => 'non@existing.user']);
        $this->assertContains('User not found', Artisan::output());
    }

    public function testBannedUsersAreLoggedOutImmediately()
    {
        $this->visit(route('authentication::session.create'))
            ->type($this->user->email, 'email')
            ->type('some-password', 'password')
            ->press(trans('authentication::session.create'))

            ->visit(route('authentication::profile.show'))
            ->seePageIs(route('authentication::profile.show'));

        $this->artisan('user:ban', ['email' => $this->user->email]);
        $this->assertContains(trans('authentication::user.banned', ['email' => $this->user->email]), Artisan::output());

        // Refresh the authenticated user as this happens on every request
        // in Laravel but while testing the old user data is used.
        auth()->setUser(app(UserRepository::class)->findByEmailAddress($this->user->email));

        $this->visit(route('authentication::profile.show'))
            ->seePageIs(route('authentication::session.create'))
            ->see(trans('authentication::user.banned', ['email' => $this->user->email]));
    }
}
