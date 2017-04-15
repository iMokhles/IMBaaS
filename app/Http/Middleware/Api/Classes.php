<?php

namespace App\Http\Middleware\Api;

use Closure;

class Classes extends BaseApiMiddleware
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
        if ($this->checkAppId($request)) {
            return $next($request);
        } else {
            return response()->json([
                'error_code' => 'Error 404',
                'error_message' => 'Something went wrong'
            ]);
        }
    }
}
