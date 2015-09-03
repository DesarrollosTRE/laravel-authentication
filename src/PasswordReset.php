<?php namespace Speelpenning\Authentication;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordReset extends Model {

    protected $table = 'password_resets';

    protected $fillable = ['email', 'token', 'created_at'];

    public $timestamps = false;

    /**
     * Generates a new password token.
     *
     * @param string $email
     * @return static
     */
    public static function generate($email)
    {
        return new static([
            'email' => $email,
            'token' => hash_hmac('sha256', Str::random(40), config('app.key')),
            'created_at' => Carbon::now(),
        ]);
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
     * Checks if the token has expired.
     *
     * @return bool
     */
    public function hasExpired()
    {
        return Carbon::now() > $this->expiresAt();
    }

    /**
     * Checks if the token is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return ! $this->hasExpired();
    }

}
