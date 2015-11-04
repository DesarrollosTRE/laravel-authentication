<?php

namespace Speelpenning\Authentication\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;

class Authenticate
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * Authenticate constructor.
     *
     * @param Guard $auth
     * @param Translator $translator
     */
    public function __construct(Guard $auth, Translator $translator)
    {
        $this->auth = $auth;
        $this->translator = $translator;
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
            } else {
                return redirect()->guest(route('authentication::session.create'));
            }
        }

        $user = $this->auth->user();

        if ($user->isBanned()) {
            $this->auth->logout();
            return redirect()->route('authentication::session.create')->withErrors([
                'authentication::login_error' => $this->translator->get('authentication::user.banned', ['email' => $user->email])
            ]);
        }

        return $next($request);
    }
}
