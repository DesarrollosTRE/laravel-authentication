<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * @var Repository
     */
    protected $config;

    /**
     * UserController constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function create()
    {
        return view('authentication::user.create');
    }


    public function store(StoreUserRequest $request)
    {
        return response('Success!');
    }

}
