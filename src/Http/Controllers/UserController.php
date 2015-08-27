<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Jobs\RegisterUser;

class UserController extends Controller {

    use DispatchesJobs;

    /**
     * @var Config
     */
    protected $config;

    /**
     * UserController constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function create()
    {
        return view('authentication::user.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->dispatchFrom(RegisterUser::class, $request);

        return redirect($this->config->get('authentication.registration.redirectUri'));
    }

}
