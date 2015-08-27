<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Exceptions\LoginFailed;
use Speelpenning\Authentication\Exceptions\SessionHasExpired;
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
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function create()
    {
        return view('authentication::session.create');
    }

    public function store(Request $request)
    {
        try {
            $this->dispatchFrom(AttemptUserLogin::class, $request);
            return redirect($this->config->get('authentication.login.redirectUri'));
        }
        catch (LoginFailed $e) {
            return redirect()->back()->withInput()->withErrors([
                'authentication::login_error' => $e->getMessage()
            ]);
        }
    }

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
