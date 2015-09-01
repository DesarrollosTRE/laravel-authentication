<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Speelpenning\Authentication\Http\Middleware\Authenticate;
use Speelpenning\Authentication\Http\Requests\UpdateUserRequest;
use Speelpenning\Authentication\Jobs\UpdateUser;

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
        return view('authentication::profile.show')
            ->with('user', $this->auth->user());
    }

    public function edit()
    {
        return view('authentication::profile.edit')
            ->with('user', $this->auth->user());
    }

    public function update(UpdateUserRequest $request)
    {
        $request->merge(['id' => $this->auth->user()->id]);

        $this->dispatchFrom(UpdateUser::class, $request);

        return redirect()->route('authentication::profile.show');
    }

}
