<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\PasswordReset;
use Speelpenning\Authentication\Repositories\PasswordResetRepository;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class PasswordResetControllerTest extends TestCase {

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

    /**
     * Generates and stores a valid reset token.
     *
     * @return PasswordReset
     */
    protected function generateReset()
    {
        $reset = PasswordReset::generate($this->user->email);
        app(PasswordResetRepository::class)->save($reset);
        return $reset;
    }

    public function testPasswordResetLinkForm()
    {
        $this->visit(route('authentication::password-reset.create'))
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::password-reset.create'));
    }

    public function testEmailAddressIsRequired()
    {
        $this->visit(route('authentication::password-reset.create'))
            ->press(trans('authentication::password-reset.create'))
            ->see('The email field is required.');
    }

    public function testAccountMustExist()
    {
        $this->visit(route('authentication::password-reset.create'))
            ->type('non@existing.user', 'email')
            ->press(trans('authentication::password-reset.create'))
            ->see('The selected email is invalid.');
    }

    public function testPasswordResetLinkCanBeSent()
    {
        $this->visit(route('authentication::password-reset.create'))
            ->type($this->user->email, 'email')
            ->press(trans('authentication::password-reset.create'))
            ->see(trans('authentication::password-reset.created'));
    }

    public function testPasswordResetForm()
    {
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->seeInField('token', $reset->token)
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::user.password'))
            ->see(trans('authentication::user.password_confirmation'))
            ->see(trans('authentication::password-reset.edit'));
    }

    public function testPasswordCanBeReset()
    {
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->type($this->user->email, 'email')
            ->type('some-new-password', 'password')
            ->type('some-new-password', 'password_confirmation')
            ->press(trans('authentication::password-reset.edit'))
            ->seePageIs(route('authentication::session.create'))
            ->see(trans('authentication::password-reset.updated'));
    }

    public function testEmailAndPasswordAreRequired()
    {
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->press(trans('authentication::password-reset.edit'))
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testEmailMustBeValid()
    {
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->type('not@existing.user', 'email')
            ->press(trans('authentication::password-reset.edit'))
            ->see('The selected email is invalid.');
    }

    public function testPasswordMustBeConfirmed()
    {
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->type($this->user->email, 'email')
            ->type('some-new-password', 'password')
            ->press(trans('authentication::password-reset.edit'))
            ->see('The password confirmation does not match.');
    }

    public function testDefaultPasswordLength()
    {
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->type($this->user->email, 'email')
            ->type('short', 'password')
            ->type('short', 'password_confirmation')
            ->press(trans('authentication::password-reset.edit'))
            ->see('The password must be at least 8 characters.');
    }

    public function testTokenCanExpire()
    {
        config(['authentication.passwordReset.expiresAfter' => -60]);
        $reset = $this->generateReset();

        $this->visit(route('authentication::password-reset.edit', ['token' => $reset->token]))
            ->seePageIs(route('authentication::password-reset.create'))
            ->see(trans('authentication::password-reset.expired'));
    }
}
