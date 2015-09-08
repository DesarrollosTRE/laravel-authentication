<?php

use Illuminate\Support\Facades\Artisan;
use Speelpenning\Authentication\User;

class RegisterUserTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $this->user = User::register('John Doe', 'john.doe@example.com', 'some-valid-password');
    }

    public function testRegistration()
    {
        $this->artisan('user:register', ['email' => $this->user->email]);
        $this->assertContains('User registered with the following password:', Artisan::output());
    }

    public function testDuplicateRegistrationFails()
    {
        $this->artisan('user:register', ['email' => $this->user->email]);
        $this->artisan('user:register', ['email' => $this->user->email]);
        $this->assertContains('The email has already been taken', Artisan::output());
    }

    public function testWithRequiredName()
    {
        config(['authentication.registration.userName' => 'required']);

        $this->artisan('user:register', ['email' => $this->user->email]);
        $this->assertContains('The name field is required', Artisan::output());

        $this->artisan('user:register', ['email' => $this->user->email, 'name' => $this->user->name]);
        $this->assertContains('User registered with the following password:', Artisan::output());
    }

    public function testRegistrationWithPasswordReset()
    {
        $this->artisan('user:register', ['email' => $this->user->email, '--with-reset' => true]);
        $this->assertContains('A password reset link has been sent.', Artisan::output());
    }

}
