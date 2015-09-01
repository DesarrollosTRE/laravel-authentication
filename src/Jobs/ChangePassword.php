<?php namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Speelpenning\Authentication\Events\PasswordWasChanged;
use Speelpenning\Authentication\Repositories\UserRepository;

class ChangePassword implements SelfHandling {

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $current_password;

    /**
     * @var string
     */
    protected $new_password;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param string $current_password
     * @param string $new_password
     */
    public function __construct($id, $current_password, $new_password)
    {
        $this->id = $id;
        $this->current_password = $current_password;
        $this->new_password = $new_password;
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
        $user = $users->find($this->id);

        if ( ! $hash->check($this->current_password, $user->password)) {
            throw new ValidationException(new MessageBag([
                'current_password' => trans('authentication::password.current_password_invalid'),
            ]));
        }

        $user->password = $hash->make($this->new_password);

        $users->save($user);

        $event->fire(new PasswordWasChanged($user));
    }
}
