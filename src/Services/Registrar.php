<?php namespace Speelpenning\Authentication\Services;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Speelpenning\Authentication\Events\UserWasRegistered;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class Registrar {

    /**
     * @var Dispatcher
     */
    protected $event;

    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * Registrar constructor.
     *
     * @param Hasher $hasher
     * @param UserRepository $users
     */
    public function __construct(Dispatcher $event, Hasher $hasher, UserRepository $users)
    {
        $this->event = $event;
        $this->hasher = $hasher;
        $this->users = $users;
    }

    /**
     * Registers a new user.
     *
     * @param StoreUserRequest $request
     * @return User
     */
    public function register(StoreUserRequest $request)
    {
        $user = User::register(
            $request->get('name'),
            $request->get('email'),
            $this->hasher->make($request->get('password'))
            );

        $this->users->save($user);

        $this->event->fire(new UserWasRegistered($user));

        return $user;
    }

}
