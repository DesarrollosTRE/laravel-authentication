<?php

use Speelpenning\Authentication\User;

class UserTest extends TestCase
{
    public function testItCanBeRegistered()
    {
        $user = User::register('John Doe', 'john.doe@example.com', 'some-password');

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertEquals('some-password', $user->password);
    }
}
