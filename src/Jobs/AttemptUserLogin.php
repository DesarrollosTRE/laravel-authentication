<?php

namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Translation\Translator;
use Speelpenning\Authentication\Events\UserHasLoggedIn;
use Speelpenning\Authentication\Events\UserLoginHasFailed;
use Speelpenning\Authentication\Exceptions\LoginFailed;
use Speelpenning\Authentication\Exceptions\UserIsBanned;

class AttemptUserLogin implements SelfHandling
{
    /**
     * Array holding the credentials provided by the user.
     *
     * @var array
     */
    protected $credentials;

    /**
     * Indicates if the user login should be remembered.
     *
     * @var bool
     */
    protected $remember;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $password
     * @param bool $remember
     */
    public function __construct($email, $password, $remember = false)
    {
        $this->credentials = compact('email', 'password');
        $this->remember = (bool)$remember;
    }

    /**
     * Execute the job.
     *
     * @param Guard $auth
     * @param Dispatcher $event
     * @param Translator $translator
     * @return void
     * @throws LoginFailed
     * @throws UserIsBanned
     */
    public function handle(Guard $auth, Dispatcher $event, Translator $translator)
    {
        if (! $auth->attempt($this->credentials, $this->remember)) {
            $event->fire(new UserLoginHasFailed($auth->user()));
            throw new LoginFailed($translator->get('authentication::session.creation_failed'));
        }

        $user = $auth->user();
        if ($user->isBanned()) {
            $auth->logout();
            throw new UserIsBanned($translator->get('authentication::user.banned', ['email' => $user->email]));
        }

        $event->fire(new UserHasLoggedIn($user));
    }
}
