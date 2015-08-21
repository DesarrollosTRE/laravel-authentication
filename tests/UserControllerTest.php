<?php

class UserControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        config([
            'authentication.enableRoutes' => true,
        ]);
    }

    public function testDefaultRegistrationForm()
    {
        $this->visit(route('authentication::user.create'))
            ->see(trans('authentication::user.name'))
            ->see(trans('authentication::user.optional'))
            ->see(trans('authentication::user.email'))
            ->see(trans('authentication::user.password'))
            ->see(trans('authentication::user.password_confirmation'))
            ->see(trans('authentication::user.create'))
            ;
    }

    public function testUsersNameIsRequired()
    {
        config([
            'authentication.registration.userName' => 'required',
        ]);

        $this->visit(route('authentication::user.create'))
            ->see(trans('authentication::user.name'))
            ->dontSee(trans('authentication::user.optional'))
        ;
    }

    public function testUserNameIsTurnedOff()
    {
        config([
            'authentication.registration.userName' => 'off',
        ]);

        $this->visit(route('authentication::user.create'))
            ->dontSee(trans('authentication::user.name'))
        ;
    }

//    public function testValidationDefaultRegistrationForm()
//    {
//
//    }

}
