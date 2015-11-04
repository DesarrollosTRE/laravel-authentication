<?php

namespace Speelpenning\Authentication\Events;

use Illuminate\Queue\SerializesModels;
use Speelpenning\Contracts\Authentication\CanBeBanned;

class UserWasUnbanned
{
    use SerializesModels;

    /**
     * @var CanBeBanned
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param CanBeBanned $user
     */
    public function __construct(CanBeBanned $user)
    {
        $this->user = $user;
    }
}
