<?php namespace Speelpenning\Authentication\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Authenticate {

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Authenticate constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            else {
                return redirect()->guest(route('authentication::session.create'));
            }
        }
        return $next($request);
    }
}
