<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Artisan;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class BanTest extends TestCase {

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

}
