<?php namespace Speelpenning\Authentication;

trait CanRegister {

    /**
     * Registers a new user.
     *
     * @param null|string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function register($name = null, $email, $password)
    {
        return new static(compact('name', 'email', 'password'));
    }

}
