<?php

namespace App\Http\Middleware\Api;

use Closure;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return response()->json([
            'error_code' => 'Error 404',
            'error_message' => 'Something went wrong'
        ]);
//        return $next($request);
    }
}
