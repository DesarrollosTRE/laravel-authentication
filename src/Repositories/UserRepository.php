<?php namespace Speelpenning\Authentication\Repositories;

use Illuminate\Database\Eloquent\Model;
use Speelpenning\Authentication\User;

class UserRepository {

    /**
     * Checks if a user with a specific e-mail address exists in the database.
     *
     * @param string $emailAddress
     * @return bool
     */
    public function exists($emailAddress)
    {
        return User::where('email', $emailAddress)->exists();
    }

    /**
     * Saves the model to the database.
     *
     * @param Model $model
     * @return bool
     */
    public function save(Model $model)
    {
        return $model->save();
    }

}
