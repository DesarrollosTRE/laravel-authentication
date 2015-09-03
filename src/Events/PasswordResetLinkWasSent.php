<?php namespace Speelpenning\Authentication\Events;

use Illuminate\Queue\SerializesModels;
use Speelpenning\Authentication\PasswordReset;

class PasswordResetLinkWasSent {

    use SerializesModels;

    /**
     * @var PasswordReset
     */
    public $passwordReset;

    /**
     * Create a new event instance.
     *
     * @param PasswordReset $passwordReset
     */
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

}
