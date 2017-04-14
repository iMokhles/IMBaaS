<?php

namespace App\Http\Middleware\Api;

use Closure;

class Analytics extends BaseApiMiddleware
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
            return response()->json([
                'error_code' => 'Success',
                'error_message' => 'Application Id Existe'
            ]);
        } else {
            return response()->json([
                'error_code' => 'Error 404',
                'error_message' => 'Something went wrong'
            ]);
        }
//        return $next($request);
    }
}
