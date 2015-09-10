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

    /**
     * Returns the field name of the manages users indicator.
     *
     * @return string
     */
    public function managesUsersIndicator()
    {
        return 'admin';
    }

}
