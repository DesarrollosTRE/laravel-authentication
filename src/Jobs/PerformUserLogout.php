<?php

namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Translation\Translator;
use Speelpenning\Authentication\Events\UserHasLoggedOut;
use Speelpenning\Authentication\Exceptions\SessionHasExpired;

class PerformUserLogout implements SelfHandling
{
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
     * @param Translator $translator
     * @return void
     * @throws SessionHasExpired
     */
    public function handle(Guard $auth, Dispatcher $event, Translator $translator)
    {
        if ($auth->guest()) {
            throw new SessionHasExpired($translator->get('authentication::session.expired'));
        }

        $user = $auth->user();

        $auth->logout();

        $event->fire(new UserHasLoggedOut($user));
    }
}
