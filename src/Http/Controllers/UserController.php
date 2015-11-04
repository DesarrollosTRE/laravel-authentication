<?php

namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Http\Requests\CreateUserRequest;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Jobs\RegisterUser;

class UserController extends Controller
{
    use DispatchesJobs;

    /**
     * Shows the registration form.
     *
     * @param CreateUserRequest $request
     * @return View
     */
    public function create(CreateUserRequest $request)
    {
        return view('authentication::user.create');
    }

    /**
     * Attempts to register the user.
     *
     * @param StoreUserRequest $request
     * @param Repository $config
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request, Repository $config)
    {
        $this->dispatchFrom(RegisterUser::class, $request);

        return redirect($config->get('authentication.registration.redirectUri'));
    }
}
