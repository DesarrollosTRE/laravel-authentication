<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Http\Middleware\Authenticate;
use Speelpenning\Authentication\Http\Requests\ChangePasswordRequest;
use Speelpenning\Authentication\Jobs\ChangePassword;

class PasswordController extends Controller {

    use DispatchesJobs;

    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function edit()
    {
        return view('authentication::password.edit');
    }

    public function update(ChangePasswordRequest $request, Guard $auth)
    {
        $request->merge(['id' => $auth->user()->id]);

        try {
            $this->dispatchFrom(ChangePassword::class, $request);
            return redirect()->route('authentication::profile.show');
        }
        catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

}
