<?php

namespace App\Http\Middleware\Api;
use Closure;

class BaseApiMiddleware
{
    /**
     * Check if the request authorized for the app
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */

    protected function checkAppId($request) {
        $appId = $request->header('X_IMBaaS_Application_Id');
        if (empty($appId)) {
            return false;
        }
        if (strlen($appId) != config('imbaas_ids.applicationIdLength')) {
            return false;
        }
        if ($appId != config('imbaas_ids.applicationId')) {
            return false;
        }
        return true;
    }
}
