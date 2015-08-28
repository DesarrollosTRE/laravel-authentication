<?php

use Speelpenning\Authentication\User;

class UserControllerTest extends TestCase {

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        config([
            'authentication.enableRoutes' => true,
        ]);

        $this->artisan('migrate:refresh');

        $this->user = User::register('John Doe', 'john.doe@example.com', 'some-valid-password');
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

    public function testEmailAddressCanBeRegisteredOnce()
    {
        $this->visit(route('authentication::user.create'))
            ->type($this->user->email, 'email')
            ->type($this->user->password, 'password')
            ->type($this->user->password, 'password_confirmation')
            ->press(trans('authentication::user.create'));

        $this->visit(route('authentication::user.create'))
            ->type($this->user->email, 'email')
            ->type($this->user->password, 'password')
            ->type($this->user->password, 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->see('The email has already been taken.');
    }

    public function testPasswordMustBeConfirmed()
    {
        $this->visit(route('authentication::user.create'))
            ->type($this->user->password, 'password')
            ->press(trans('authentication::user.create'))
            ->see('The password confirmation does not match.');
    }

    public function testDefaultPasswordLength()
    {
        $this->visit(route('authentication::user.create'))
            ->type(1234, 'password')
            ->type(1234, 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->see('The password must be at least 8 characters.');
    }

    public function testPasswordLengthCanBeConfigured()
    {
        config(['authentication.password.minLength' => 10]);

        $this->visit(route('authentication::user.create'))
            ->type(1234, 'password')
            ->type(1234, 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->see('The password must be at least 10 characters.');
    }

    public function testSuccessfulRegistrationAndRedirection()
    {
        config(['authentication.registration.redirectUri' => route('authentication::user.create')]);

        $this->visit(route('authentication::user.create'))
            ->type($this->user->name, 'name')
            ->type($this->user->email, 'email')
            ->type($this->user->password, 'password')
            ->type($this->user->password, 'password_confirmation')
            ->press(trans('authentication::user.create'))
            ->seePageIs(route('authentication::user.create'));
    }

    public function testRememberOldInputAfterFailedRegistration()
    {
        $this->visit(route('authentication::user.create'))
            ->type($this->user->name, 'name')
            ->type($this->user->email, 'email')
            ->press(trans('authentication::user.create'))
            ->seeInField('name', $this->user->name)
            ->seeInField('email', $this->user->email);
    }

}
