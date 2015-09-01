<?php namespace Speelpenning\Authentication\Events;

use Illuminate\Queue\SerializesModels;
use Speelpenning\Authentication\User;

class UserLoginHasFailed {

    use SerializesModels;

    /**
     * @var string
     */
    public $email;

    /**
     * Create a new event instance.
     *
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

}
