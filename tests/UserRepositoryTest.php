<?php

use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class UserRepositoryTest extends TestCase {

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $this->repository = app(UserRepository::class);
        $this->user = User::register('John Doe', 'john.doe@example.com', 'some-password');
    }

    public function testItSavesUsers()
    {
        $this->assertTrue($this->repository->save($this->user));
    }

    public function testItChecksIfAUserExists()
    {
        $this->repository->save($this->user);

        $this->assertTrue($this->repository->exists($this->user->email));
        $this->assertFalse($this->repository->exists('non@existing.user'));
    }

}
