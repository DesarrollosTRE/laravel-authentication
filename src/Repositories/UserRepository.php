<?php namespace Speelpenning\Authentication\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Speelpenning\Authentication\User;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract {

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
     * Finds a user by id.
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Finds a user by e-mail address.
     *
     * @param string $emailAddress
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByEmailAddress($emailAddress)
    {
        return User::where('email', $emailAddress)->firstOrFail();
    }

    /**
     * Saves the model to the database.
     *
     * @param Authenticatable $model
     * @return bool
     */
    public function save(Authenticatable $model)
    {
        return $model->save();
    }

}
