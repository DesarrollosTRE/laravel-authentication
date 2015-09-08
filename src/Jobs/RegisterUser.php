<?php namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Speelpenning\Authentication\Events\UserWasRegistered;
use Speelpenning\Authentication\User;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class RegisterUser implements SelfHandling {

    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * Create a new job instance.
     *
     * @param null|string $name
     * @param string $email
     * @param string $password
     */
    public function __construct($name = null, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @param Hasher $hash
     * @param UserRepository $users
     * @param Dispatcher $event
     * @return void
     */
    public function handle(Hasher $hash, UserRepository $users, Dispatcher $event)
    {
        $user = User::register($this->name, $this->email, $hash->make($this->password));

        $users->save($user);

        $event->fire(new UserWasRegistered($user));
    }

}
