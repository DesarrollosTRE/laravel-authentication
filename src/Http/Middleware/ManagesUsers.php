<?php namespace Speelpenning\Authentication\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Speelpenning\Authentication\Exceptions\MissingManagesUsers;
use Speelpenning\Contracts\Authentication\ManagesUsers as ManagesUsersContract;

class ManagesUsers {

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Authenticate constructor.
     *
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
     * @throws MissingManagesUsers
     */
    public function handle($request, Closure $next)
    {
        if ( ! $this->auth->user() instanceof ManagesUsersContract) {
            throw new MissingManagesUsers(trans('authentication::user.missing_manage_users'));
        }

        if ( ! $this->auth->user()->managesUsers()) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }

}
