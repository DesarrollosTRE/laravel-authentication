<?php  namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;
use Illuminate\Translation\Translator;
use Speelpenning\Authentication\Events\UserHasLoggedIn;
use Speelpenning\Authentication\Exceptions\LoginFailed;

class AttemptUserLogin implements SelfHandling {

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
     */
    public function handle(Guard $auth, Dispatcher $event, Translator $translator)
    {
        if ( ! $auth->attempt($this->credentials, $this->remember)) {
            throw new LoginFailed($translator->get('authentication::session.creation_failed'));
        }

        $event->fire(new UserHasLoggedIn($auth->user()));
    }

}
