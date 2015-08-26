<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Services\Registrar;

class UserController extends Controller {

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

    public function store(StoreUserRequest $request, Registrar $registrar)
    {
        $registrar->register($request);
        return response('Success!');
    }

}
