<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;

class ProfileController extends Controller {

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

    public function show()
    {
        return 'show';
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
