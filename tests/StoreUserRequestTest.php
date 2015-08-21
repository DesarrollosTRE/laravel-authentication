<?php

use Speelpenning\Authentication\Http\Requests\StoreUserRequest;

class StoreUserRequestTest extends TestCase {

    public function testDefaultValidationRules()
    {
        $request = app(StoreUserRequest::class);

        $this->assertEquals([
            'name' => ['sometimes', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'string', 'min:' . config('authentication.password.minLength')],
        ], $request->getRules());
    }

}
