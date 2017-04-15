<?php

namespace App\Http;

// iMBaaS Middlewares
use App\Http\Middleware\Api\Analytics;
use App\Http\Middleware\Api\Classes;
use App\Http\Middleware\Api\Files;
use App\Http\Middleware\Api\Installations;
use App\Http\Middleware\Api\Pushs;
use App\Http\Middleware\Api\Roles;
use App\Http\Middleware\Api\Schemas;
use App\Http\Middleware\Api\Sessions;
use App\Http\Middleware\Api\Users;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api_users' => [
            Users::class
        ],
        'api_sessions' => [
            Sessions::class
        ],
        'api_roles' => [
            Roles::class
        ],
        'api_pushs' => [
            Pushs::class
        ],
        'api_installations' => [
            Installations::class
        ],
        'api_files' => [
            Files::class
        ],
        'api_classes' => [
            Classes::class
        ],
        'api_analytics' => [
            Analytics::class
        ],
        'api_schemas' => [
            Schemas::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

    ];
}
