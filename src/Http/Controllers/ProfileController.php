<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Http\Middleware\Authenticate;

class ProfileController extends Controller {

    use DispatchesJobs;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * UserController constructor.
     *
     * @param Config $config
     * @param Guard $auth
     */
    public function __construct(Config $config, Guard $auth)
    {
        $this->middleware(Authenticate::class);

        $this->config = $config;
        $this->auth = $auth;
    }

    public function show()
    {
        return view('authentication::user.show')->with('user', $this->auth->user());
    }

    public function edit()
    {
        return 'edit';
    }

    public function update()
    {
        return 'update';

        $this->dispatchFrom(null, $request);

        return redirect('authentication::profile.show');
    }

}
