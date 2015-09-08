<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Exceptions\TokenHasExpired;
use Speelpenning\Authentication\Http\Requests\SendPasswordResetLinkRequest;
use Speelpenning\Authentication\Http\Requests\ResetPasswordRequest;
use Speelpenning\Authentication\Jobs\ResetPassword;
use Speelpenning\Authentication\Jobs\SendPasswordResetLink;
use Speelpenning\Contracts\Authentication\Repositories\PasswordResetRepository;

class PasswordResetController extends Controller {

    use DispatchesJobs;

    /**
     * Displays the request reset password link form.
     *
     * @return View
     */
    public function create()
    {
        return view('authentication::password-reset.create');
    }

    /**
     * Attempts to send the password reset link to the user.
     *
     * @param SendPasswordResetLinkRequest $request
     * @return RedirectResponse
     */
    public function store(SendPasswordResetLinkRequest $request)
    {
        $this->dispatchFrom(SendPasswordResetLink::class, $request);

        return redirect()->route('authentication::password-reset.create')->withErrors([
            'authentication::password-reset.created' => trans('authentication::password-reset.created'),
        ]);
    }

    /**
     * Shows the password reset form.
     *
     * @param string $token
     * @param PasswordResetRepository $resets
     * @return View|RedirectResponse
     */
    public function edit($token, PasswordResetRepository $resets)
    {
        if ($resets->exists($token)) {
            return view('authentication::password-reset.edit')->with('token', $token);
        }
        else {
            return redirect()->route('authentication::password-reset.create')->withErrors([
                'authentication::password-reset.expired' => trans('authentication::password-reset.expired'),
            ]);
        }
    }

    /**
     * Attempts to reset the password.
     *
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function update(ResetPasswordRequest $request)
    {
        try {
            $this->dispatchFrom(ResetPassword::class, $request);

            return redirect()->route('authentication::session.create')->withErrors([
                'authentication::password-reset.updated' => trans('authentication::password-reset.updated'),
            ]);
        }
        catch (TokenHasExpired $e) {
            return redirect()->route('authentication::password-reset.create')->withErrors([
                'authentication::password-reset.expired' => trans('authentication::password-reset.expired'),
            ]);
        }
    }

}
