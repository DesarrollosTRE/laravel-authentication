<?php namespace Speelpenning\Authentication\Http\Controllers\Administration;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Http\Middleware\Authenticate;
use Speelpenning\Authentication\Http\Middleware\ManagesUsers;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class UserController extends Controller {

    use DispatchesJobs;

    public function __construct()
    {
        $this->middleware(Authenticate::class);
        $this->middleware(ManagesUsers::class);
    }

    /**
     * Shows the user index.
     *
     * @param UserRepository $users
     * @param Request $request
     * @return View
     */
    public function index(UserRepository $users, Request $request)
    {
        return view('authentication::user.index')
            ->with('users', $users->query($request->get('q')));
    }

}
