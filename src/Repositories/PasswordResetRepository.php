<?php namespace Speelpenning\Authentication\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Speelpenning\Authentication\PasswordReset;
use Speelpenning\Contracts\Authentication\ExpirableToken;
use Speelpenning\Contracts\Authentication\Repositories\PasswordResetRepository as PasswordResetRepositoryContract;

class PasswordResetRepository implements PasswordResetRepositoryContract {

    /**
     * Checks if a certain password reset exists.
     *
     * @param string $token
     * @return bool
     */
    public function exists($token)
    {
        $reset = PasswordReset::where('token', $token)->first();
        return $reset and ! $reset->hasExpired();
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
     * @param ExpirableToken $passwordReset
     * @return bool
     */
    public function save(ExpirableToken $passwordReset)
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
