<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Speelpenning\Authentication\Exceptions\LoginFailed;
use Speelpenning\Authentication\Exceptions\RememberingUserFailed;
use Speelpenning\Authentication\Exceptions\SessionHasExpired;
use Speelpenning\Authentication\Exceptions\UserIsBanned;
use Speelpenning\Authentication\Jobs\AttemptRememberingUser;
use Speelpenning\Authentication\Jobs\AttemptUserLogin;
use Speelpenning\Authentication\Jobs\PerformUserLogout;

class SessionController extends Controller {

    use DispatchesJobs;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * SessionController constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Attempts to authenticate by remember token. When remembering fails the login form is shown.
     *
     * @return RedirectResponse|View
     */
    public function create()
    {
        try {
            $this->dispatch(new AttemptRememberingUser());
            return redirect()->intended($this->config->get('authentication.login.redirectUri'));
        }
        catch (RememberingUserFailed $e) {
            return view('authentication::session.create');
        }
    }

    /**
     * Attempts to login the user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->dispatchFrom(AttemptUserLogin::class, $request);
            return redirect()->intended($this->config->get('authentication.login.redirectUri'));
        }
        catch (LoginFailed $e) {
            return redirect()->back()->withInput()->withErrors([
                'authentication::login_error' => $e->getMessage()
            ]);
        }
        catch (UserIsBanned $e) {
            return redirect()->back()->withInput()->withErrors([
                'authentication::login_error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Attempts to log off the user.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        try {
            $this->dispatch(new PerformUserLogout());
            return redirect($this->config->get('authentication.logout.redirectUri'));
        }
        catch (SessionHasExpired $e) {
           return redirect()->route('authentication::session.create')->withErrors([
               'authentication::login_warning' => $e->getMessage()
           ]);
        }
    }

}
