<?php

namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Http\Middleware\Authenticate;
use Speelpenning\Authentication\Http\Requests\ChangePasswordRequest;
use Speelpenning\Authentication\Jobs\ChangePassword;

class PasswordController extends Controller
{
    use DispatchesJobs;

    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    /**
     * Displays the change password form.
     *
     * @return View
     */
    public function edit()
    {
        return view('authentication::password.edit');
    }

    /**
     * Attempts to update the password.
     *
     * @param ChangePasswordRequest $request
     * @param Guard $auth
     * @return $this|RedirectResponse
     */
    public function update(ChangePasswordRequest $request, Guard $auth)
    {
        $request->merge(['id' => $auth->user()->id]);

        try {
            $this->dispatchFrom(ChangePassword::class, $request);
            return redirect()->route('authentication::profile.show');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }
}
