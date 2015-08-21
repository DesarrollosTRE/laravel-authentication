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

}
