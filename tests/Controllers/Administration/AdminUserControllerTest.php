<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
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

        return $this;
    }

    public function testMustManageUsers()
    {
        $user = app(UserRepository::class)->findByEmailAddress('another.user@example.com');
        $this->actingAs($user);

        $this->get(route('authentication::user.index'))
            ->assertResponseStatus(401);
    }

    public function testUserIndex()
    {
        $this->login()
            ->visit(route('authentication::user.index'))
            ->see(trans('authentication::user.index'))
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::user.name'))
            ->see(trans('authentication::user.created_at'))
            ->see(trans('authentication::user.administrator'))
            ->see('John Doe')
            ->see('John Doe Sr.')
            ->see('Another User');
    }

    public function testUserDetails()
    {
        $this->login()
            ->visit(route('authentication::user.index'))
            ->click($this->user->email)
            ->see(trans('authentication::user.show'))
            ->see(trans('authentication::user.email'))
            ->see($this->user->email)
            ->see(trans('authentication::user.name'))
            ->see($this->user->name)
            ->see(trans('authentication::user.created_at'))
            ->see($this->user->created_at)
            ->see(trans('authentication::user.administrator'))
            ->see(trans('authentication::user.index'));
    }

    public function testUserCanBeBannedAndUnbanned()
    {
        $this->login()
            ->visit(route('authentication::user.index'))
            ->click('another.user@example.com')
            ->see(trans('authentication::user.ban'))
            ->press(trans('authentication::user.ban'))
            ->see(trans('authentication::user.unban'))
            ->see(app(UserRepository::class)->findByEmailAddress('another.user@example.com')->isBannedSince())
            ->press(trans('authentication::user.unban'))
            ->see(trans('authentication::user.ban'));
    }

}
