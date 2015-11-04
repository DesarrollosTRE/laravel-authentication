<?php

namespace Speelpenning\Authentication\Events;

use Illuminate\Queue\SerializesModels;
use Speelpenning\Contracts\Authentication\ExpirableToken;

class PasswordResetLinkWasSent
{
    use SerializesModels;

    /**
     * @var ExpirableToken
     */
    public $passwordReset;

    /**
     * Create a new event instance.
     *
     * @param ExpirableToken $passwordReset
     */
    public function __construct(ExpirableToken $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }
}
