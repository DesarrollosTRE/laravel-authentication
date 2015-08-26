<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase {

    use DatabaseMigrations, DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        config([
            'authentication.enableRoutes' => true,
        ]);
    }

    public function testDefaultRegistrationForm()
    {
        $this->visit(route('authentication::user.create'))
            ->see(trans('authentication::user.name'))
            ->see(trans('authentication::user.optional'))
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::user.password'))
            ->see(trans('authentication::user.password_confirmation'))
            ->see(trans('authentication::user.create'));
    }

    public function testUserNameCanBeSwitchedOff()
    {
        config(['authentication.registration.userName' => 'off']);

        $this->visit(route('authentication::user.create'))
            ->dontSee(trans('authentication::user.name'));
    }

    public function testUserNameCanBeRequired()
    {
        config(['authentication.registration.userName' => 'required']);

        $this->visit(route('authentication::user.create'))
            ->see(trans('authentication::user.name'))
            ->dontSee(trans('authentication::user.optional'))
            ->press(trans('authentication::user.create'))
            ->see('The name field is required.');
    }

    public function testEmailAddressAndPasswordAreRequired()
    {
        $this->visit(route('authentication::user.create'))
            ->press(trans('authentication::user.create'))
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testEmailAddressMustBeValid()
    {
        $this->visit(route('authentication::user.create'))
            ->type('invalid-email-address', 'email')
            ->press(trans('authentication::user.create'))
            ->see('The email must be a valid email address.');
    }

    public function testPasswordMustBeConfirmed()
    {
        $this->visit(route('authentication::user.create'))
            ->type('some-password', 'password')
            ->press(trans('authentication::user.create'))
            ->see('The password confirmation does not match.');
    }

    public function testDefaultPasswordLength()
    {
        $this->visit(route('authentication::user.create'))
            ->type('short', 'password')
            ->type('short', 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->see('The password must be at least 8 characters.');
    }

    public function testPasswordLengthCanBeConfigured()
    {
        config(['authentication.password.minLength' => 10]);

        $this->visit(route('authentication::user.create'))
            ->type('short', 'password')
            ->type('short', 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->see('The password must be at least 10 characters.');
    }

    public function testSuccessfulRegistration()
    {
        $this->visit(route('authentication::user.create'))
            ->type('John Doe', 'name')
            ->type('john.doe@example.com', 'email')
            ->type('some-valid-password', 'password')
            ->type('some-valid-password', 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->see('Success!');
    }

}
