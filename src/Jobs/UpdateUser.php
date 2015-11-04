<?php

namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Speelpenning\Authentication\Events\UserWasUpdated;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class UpdateUser implements SelfHandling
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param null|string $name
     * @param string $email
     */
    public function __construct($id, $name = null, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
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

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $users->save($user);

        $event->fire(new UserWasUpdated($user));
    }
}
