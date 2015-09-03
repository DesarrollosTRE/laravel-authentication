<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Exceptions\TokenHasExpired;
use Speelpenning\Authentication\Http\Requests\SendPasswordResetLinkRequest;
use Speelpenning\Authentication\Http\Requests\ResetPasswordRequest;
use Speelpenning\Authentication\Jobs\ResetPassword;
use Speelpenning\Authentication\Jobs\SendPasswordResetLink;
use Speelpenning\Authentication\Repositories\PasswordResetRepository;

class PasswordResetController extends Controller {

    use DispatchesJobs;

    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
    }

    public function create()
    {
        return view('authentication::password-reset.create');
    }

    public function store(SendPasswordResetLinkRequest $request)
    {
        $this->dispatchFrom(SendPasswordResetLink::class, $request);

        return redirect()->route('authentication::password-reset.create')->withErrors([
            'authentication::password-reset.created' => trans('authentication::password-reset.created'),
        ]);
    }

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
