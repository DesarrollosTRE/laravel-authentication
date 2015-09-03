<?php namespace Speelpenning\Authentication\Repositories;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Speelpenning\Authentication\PasswordReset;

class PasswordResetRepository {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * PasswordResetRepository constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Checks if a certain password reset exists.
     *
     * @param string $token
     * @return bool
     */
    public function exists($token)
    {
        $reset = PasswordReset::where('token', $token)->first();
        return $reset and $reset->isValid();
    }

    /**
     * Finds a password reset by token.
     *
     * @param string $token
     * @return PasswordReset
     * @throws ModelNotFoundException
     */
    public function findByToken($token)
    {
        return PasswordReset::where('token', $token)->firstOrFail();
    }

    /**
     * Finds a password reset by e-mail address and token.
     *
     * @param string $email
     * @param string $token
     * @return PasswordReset
     * @throws ModelNotFoundException
     */
    public function findByEmailAndToken($email, $token)
    {
        return PasswordReset::where('email', $email)
            ->where('token', $token)
            ->firstOrFail();
    }

    /**
     * Saves a password reset in the database.
     *
     * @param PasswordReset $passwordReset
     * @return bool
     */
    public function save(PasswordReset $passwordReset)
    {
        return $passwordReset->save();
    }

    /**
     * Deletes the password resets for a certain e-mail address.
     *
     * @param string $email
     * @return int
     */
    public function cleanUp($email)
    {
        return PasswordReset::where('email', $email)->delete();
    }

}
