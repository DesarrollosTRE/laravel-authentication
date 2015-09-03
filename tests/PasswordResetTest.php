<?php

use Speelpenning\Authentication\PasswordReset;

class PasswordResetTest extends TestCase {


    protected function generatePasswordReset()
    {
        return PasswordReset::generate('john.doe@example.com');
    }

    public function testItCanBeGenerated()
    {
        $reset = $this->generatePasswordReset();

        $this->assertEquals('john.doe@example.com', $reset->email);
        $this->assertNotEmpty($reset->token);
    }

    public function testItCanExpire()
    {
        config(['authentication.passwordReset.expiresAfter']);

    }

}
