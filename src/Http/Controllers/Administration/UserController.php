<?php namespace Speelpenning\Authentication\Http\Controllers\Administration;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Http\Middleware\Authenticate;
use Speelpenning\Authentication\Http\Middleware\ManagesUsers;
use Speelpenning\Authentication\Jobs\BanUser;
use Speelpenning\Authentication\Jobs\UnbanUser;
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
     * @param Request $request
     * @param UserRepository $users
     * @return View
     */
    public function index(Request $request, UserRepository $users)
    {
        return view('authentication::user.index')
            ->with('users', $users->query($request->get('q')));
    }

    /**
     * Shows the user details.
     *
     * @param int $id
     * @param UserRepository $users
     * @return View
     */
    public function show($id, UserRepository $users)
    {
        return view('authentication::user.show')
            ->with('user', $users->find($id));
    }

    /**
     * Bans the user.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function ban($id)
    {
        $this->dispatchFromArray(BanUser::class, compact('id'));

        return redirect()->route('authentication::user.show', $id);
    }

    /**
     * Unbans the user.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function unban($id)
    {
        $this->dispatchFromArray(UnbanUser::class, compact('id'));

        return redirect()->route('authentication::user.show', $id);
    }

}
