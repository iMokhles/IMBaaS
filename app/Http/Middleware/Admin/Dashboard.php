<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            if (!Auth::guard($guard)->user()->hasRole('adminstrator')) {
                return redirect('/error/404');
            }
        } else {
            if ($request->path() != '/login') {
                return redirect('/error/404');
            }
        }
        return $next($request);
    }
}
