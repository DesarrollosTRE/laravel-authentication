<?php namespace Speelpenning\Authentication;

use DateTime;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Speelpenning\Contracts\Authentication\CanBeBanned as CanBeBannedContract;
use Speelpenning\Contracts\Authentication\CanRegister as CanRegisterContract;
use Speelpenning\Contracts\Authentication\ManagesUsers as ManagesUsersContract;

class User extends Model implements AuthenticatableContract, CanBeBannedContract, CanRegisterContract, ManagesUsersContract {

    use Authenticatable, CanBeBanned, CanRegister, ManagesUsers;

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

}
