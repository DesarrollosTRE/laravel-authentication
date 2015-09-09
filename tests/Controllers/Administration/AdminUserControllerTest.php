<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Artisan;
use Speelpenning\Authentication\Jobs\RegisterUser;
use Speelpenning\Authentication\Repositories\UserRepository;
use Speelpenning\Authentication\User;

class AdminUserControllerTest extends TestCase {

    use DispatchesJobs;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('vendor:publish');
        $this->artisan('migrate:refresh');

        $this->dispatchFrom(RegisterUser::class, User::register('John Doe', 'john.doe@example.com', 'some-password'));
        $this->dispatchFrom(RegisterUser::class, User::register('John Doe Sr.', 'john.doe.sr@example.com', 'some-password'));
        $this->dispatchFrom(RegisterUser::class, User::register('Another User', 'another.user@example.com', 'some-password'));

        $this->artisan('user:admin', ['email' => 'john.doe@example.com']);

        $this->user = app(UserRepository::class)->findByEmailAddress('john.doe@example.com');
    }

    protected function login()
    {
        $this->actingAs($this->user);
        $this->assertTrue($this->user->managesUsers());
    }

    public function testUserIndex()
    {
        $this->login();

        $this->visit(route('authentication::admin.user.index'))
            ->see(trans('authentication::user.index'))
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::user.name'))
            ->see(trans('authentication::user.created_at'))
            ->see('John Doe')
            ->see('John Doe Sr.')
            ->see('Another User');
    }

}
