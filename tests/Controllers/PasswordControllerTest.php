<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class PasswordControllerTest extends TestCase {

    use DispatchesJobs;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $this->dispatchFrom(RegisterUser::class, User::register('John Doe', 'john.doe@example.com', 'some-password'));
        $this->user = app(UserRepository::class)->findByEmailAddress('john.doe@example.com');
    }

    protected function login()
    {
        $this->actingAs($this->user);
    }

    public function testItRequiresAuthentication()
    {
        $this->visit(route('authentication::password.edit'))
            ->seePageIs(route('authentication::session.create'));
    }

    public function testPasswordCanBeChangedIfAuthenticated()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->seePageIs(route('authentication::password.edit'))
            ->see(trans('authentication::password.current_password'))
            ->see(trans('authentication::password.new_password'))
            ->see(trans('authentication::password.confirm_new_password'))
            ->see(trans('authentication::password.update'));
    }

    public function testPasswordCanBeChanged()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->type('some-password', 'current_password')
            ->type('new-password', 'new_password')
            ->type('new-password', 'new_password_confirmation')
            ->press(trans('authentication::password.update'))
            ->seePageIs(route('authentication::profile.show'));
    }

    public function testPasswordFieldsAreRequired()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->press(trans('authentication::password.update'))
            ->see('The current password field is required.')
            ->see('The new password field is required.');
    }

    public function testCurrentPasswordMustMatch()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->type('invalid', 'current_password')
            ->type('new-password', 'new_password')
            ->type('new-password', 'new_password_confirmation')
            ->press(trans('authentication::password.update'))
            ->see(trans('authentication::password.current_password_invalid'));
    }

    public function testNewPasswordMustBeConfirmed()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->type('some-password', 'current_password')
            ->type('new-password', 'new_password')
            ->type('different-password', 'new_password_confirmation')
            ->press(trans('authentication::password.update'))
            ->see('The new password confirmation does not match.');
    }

    public function testNewPasswordMustBeDifferent()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->type('some-password', 'current_password')
            ->type('some-password', 'new_password')
            ->type('some-password', 'new_password_confirmation')
            ->press(trans('authentication::password.update'))
            ->see('The new password and current password must be different.');
    }

    public function testNewPasswordHasAMinimumLength()
    {
        $this->login();

        $this->visit(route('authentication::password.edit'))
            ->type('some-password', 'current_password')
            ->type('short', 'new_password')
            ->type('short', 'new_password_confirmation')
            ->press(trans('authentication::password.update'))
            ->see('The new password must be at least ' . config('authentication.password.minLength') . ' characters.');
    }

}
