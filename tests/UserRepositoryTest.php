<?php

use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class UserRepositoryTest extends TestCase
{
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

    protected function saveUser()
    {
        return $this->repository->save($this->user);
    }

    public function testItSavesUsers()
    {
        $this->assertTrue($this->saveUser());
    }

    public function testItChecksIfAUserExists()
    {
        $this->saveUser();

        $this->assertTrue($this->repository->exists($this->user->email));
        $this->assertFalse($this->repository->exists('non@existing.user'));
    }

    public function testItFindsUsersById()
    {
        $this->saveUser();

        $this->assertInstanceOf(User::class, $this->repository->find(1));
    }

    public function testItFindsUsersByEmailAddress()
    {
        $this->saveUser();
        
        $this->assertInstanceOf(User::class, $this->repository->findByEmailAddress($this->user->email));
    }
}
