<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        if(Auth::check()) {
            $account = Accounts::where('id', Auth::user()->id)->first();

            if($account) {
                if(strtotime($account->last_active) < strtotime('-' . config('session.lifetime') . ' minutes')) {
                    Accounts::where('id', Auth::user()->id)->update([
                        'last_active' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        return $next($request);
    }
}
