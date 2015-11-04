<?php namespace Speelpenning\Authentication;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Speelpenning\Contracts\Authentication\ExpirableToken;

class PasswordReset extends Model implements ExpirableToken {

    protected $table = 'password_resets';

    protected $fillable = ['email', 'token', 'created_at'];

    public $timestamps = false;

    /**
     * Generates a new password token.
     *
     * @param Authenticatable $user
     * @return PasswordReset
     */
    public static function generate(Authenticatable $user)
    {
        return new static([
            'email' => $user->email,
            'token' => hash_hmac('sha256', Str::random(40), config('app.key')),
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * Returns the reset token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Calculates the moment at which the token expires.
     *
     * @return Carbon
     */
    public function expiresAt()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->addMinutes(config('authentication.passwordReset.expiresAfter'));
    }

    /**
     * Checks if the token is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return Carbon::now() > $this->expiresAt();
    }

}
