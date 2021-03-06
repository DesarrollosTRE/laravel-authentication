<?php

namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Speelpenning\Authentication\Events\PasswordWasReset;
use Speelpenning\Authentication\Exceptions\TokenIsExpired;
use Speelpenning\Contracts\Authentication\Repositories\PasswordResetRepository;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class ResetPassword implements SelfHandling
{
    /**
     * @var string
     */
    protected $token;

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
     * @param string $token
     * @param string $email
     * @param string $password
     */
    public function __construct($token, $email, $password)
    {
        $this->token = $token;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @param PasswordResetRepository $resets
     * @param Hasher $hash
     * @param UserRepository $users
     * @param Dispatcher $event
     */
    public function handle(PasswordResetRepository $resets, Hasher $hash, UserRepository $users, Dispatcher $event)
    {
        $reset = $resets->findByEmailAndToken($this->email, $this->token);

        if ($reset->isExpired()) {
            throw new TokenIsExpired();
        }

        $user = $users->findByEmailAddress($this->email);
        $user->password = $hash->make($this->password);
        $users->save($user);

        $event->fire(new PasswordWasReset($user));
    }
}
