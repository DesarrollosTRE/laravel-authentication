<?php

namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Speelpenning\Authentication\Events\UserWasBanned;
use Speelpenning\Authentication\Events\UserWasUnbanned;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class UnbanUser implements SelfHandling
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Create a new job instance.
     *
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $users
     * @param Dispatcher $event
     * @return void
     */
    public function handle(UserRepository $users, Dispatcher $event)
    {
        $user = $users->find($this->id);

        $user->unban();

        $users->save($user);

        $event->fire(new UserWasUnbanned($user));
    }
}
