<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class UserRepositoryTest extends TestCase {

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @var UserRepository
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = app(UserRepository::class);
    }

    protected function defaultUser()
    {
        return User::register('John Doe', 'john.doe@example.com', 'some-password');
    }

    public function testItSavesAUserModel()
    {
        $user = $this->defaultUser();
        $this->repository->save($user);

        $this->seeInDatabase('users', ['email' => 'john.doe@example.com']);
    }

}
