<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Http\Middleware\Authenticate;
use Speelpenning\Authentication\Http\Requests\UpdateUserRequest;
use Speelpenning\Authentication\Jobs\UpdateUser;

class ProfileController extends Controller {

    use DispatchesJobs;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * UserController constructor.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->middleware(Authenticate::class);

        $this->auth = $auth;
    }

    /**
     * Shows the user profile.
     *
     * @return View
     */
    public function show()
    {
        return view('authentication::profile.show')
            ->with('user', $this->auth->user());
    }

    /**
     * Shows the profile edit form.
     *
     * @return View
     */
    public function edit()
    {
        return view('authentication::profile.edit')
            ->with('user', $this->auth->user());
    }

    /**
     * Attempts to update the user profile.
     *
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $request->merge(['id' => $this->auth->user()->id]);

        $this->dispatchFrom(UpdateUser::class, $request);

        return redirect()->route('authentication::profile.show');
    }

}
