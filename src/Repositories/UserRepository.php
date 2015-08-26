<?php namespace Speelpenning\Authentication\Repositories;

use Illuminate\Database\Eloquent\Model;
use Speelpenning\Contracts\Authentication\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract {

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
