<?php namespace Speelpenning\Authentication;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Speelpenning\Contracts\Authentication\CanRegister as CanRegisterContract;
use Speelpenning\Contracts\Authentication\ManagesUsers as ManagesUsersContract;

class User extends Model implements AuthenticatableContract, CanRegisterContract, ManagesUsersContract {

    use Authenticatable, CanRegister, ManagesUsers;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

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
