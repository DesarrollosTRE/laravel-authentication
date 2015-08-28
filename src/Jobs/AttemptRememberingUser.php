<?php  namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;
use Speelpenning\Authentication\Events\UserWasRemembered;
use Speelpenning\Authentication\Exceptions\RememberingUserFailed;

class AttemptRememberingUser implements SelfHandling {

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @param Guard $auth
     * @param Dispatcher $event
     * @return void
     */
    public function handle(Guard $auth, Dispatcher $event)
    {
        if ($auth->check() and $auth->viaRemember()) {
            $event->fire(new UserWasRemembered($auth->user()));
        }

        if ($auth->check()) {
            return;
        }

        throw new RememberingUserFailed();
    }

}
