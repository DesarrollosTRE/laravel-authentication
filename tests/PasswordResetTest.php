<?php

use Speelpenning\Authentication\PasswordReset;
use Speelpenning\Authentication\User;

class PasswordResetTest extends TestCase
{
    protected function generatePasswordReset()
    {
        return PasswordReset::generate(User::register('John Doe', 'john.doe@example.com', 'some-password'));
    }

    public function testItCanBeGenerated()
    {
        $reset = $this->generatePasswordReset();

        $this->assertNotEmpty($reset->token);
    }

    public function testItHasAnExpirationTime()
    {
        $reset = $this->generatePasswordReset();

        $this->assertInstanceOf(DateTimeInterface::class, $reset->expiresAt());
    }

    public function testItCanBeValid()
    {
        $reset = $this->generatePasswordReset();

        $this->assertFalse($reset->isExpired());
    }

    public function testItCanExpire()
    {
        config(['authentication.passwordReset.expiresAfter' => -60]);

        $reset = $this->generatePasswordReset();

        $this->assertTrue($reset->isExpired());
    }
}
