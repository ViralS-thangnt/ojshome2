<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;

class Authenticate {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(LOGIN_PATH);
            }
        } elseif (Session::has(REQUIRE_PERMISSION)) {
            //check user permission
            $user = $this->auth->user();
            $user_permission = explode(',', $user->actor_no);
            $require_permission = Session::get(REQUIRE_PERMISSION);
            //destroy REQUIRE_PERMISSION
            Session::forget(REQUIRE_PERMISSION);
            
            if (!in_array($require_permission, $user_permission)) {
                return redirect(REDIRECT_PATH);
            }
        }

        return $next($request);
    }
}
