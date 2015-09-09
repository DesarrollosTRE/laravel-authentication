<?php namespace Speelpenning\Authentication;

trait ManagesUsers {

    /**
     * Indicates if managing users is allowed.
     *
     * @return bool
     */
    public function managesUsers()
    {
        return (bool)$this->{$this->managesUsersIndicator()};
    }

}
