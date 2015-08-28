<?php namespace Speelpenning\Authentication\Events;

use Illuminate\Queue\SerializesModels;
use Speelpenning\Authentication\User;

class UserWasRemembered
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
