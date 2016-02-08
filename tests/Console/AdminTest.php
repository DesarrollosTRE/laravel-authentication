<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Artisan;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\Repositories\UserRepository;

class AdminTest extends TestCase
{
    use DispatchesJobs;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('vendor:publish');
        $this->artisan('migrate:refresh');

        $this->dispatch(new RegisterUser('John Doe', 'john.doe@example.com', 'some-password'));
        $this->user = app(UserRepository::class)->findByEmailAddress('john.doe@example.com');
    }

    public function testGranting()
    {
        $this->artisan('user:admin', ['email' => $this->user->email]);
        $this->assertContains("User {$this->user->email} is granted administrator privileges.", Artisan::output());
    }

    public function testRevoking()
    {
        $this->artisan('user:admin', ['email' => $this->user->email, '--revoke' => true]);
        $this->assertContains("Administrator privileges revoked for user {$this->user->email}.", Artisan::output());
    }

    public function testUserMustExist()
    {
        $this->artisan('user:admin', ['email' => 'non@existing.user']);
        $this->assertContains('User not found', Artisan::output());
    }
}
