<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapApiSchemasRoutes();
        $this->mapApiUsersRoutes();
        $this->mapApiSessionsRoutes();
        $this->mapApiRolesRoutes();
        $this->mapApiPushsRoutes();
        $this->mapApiInstallationsRoutes();
        $this->mapApiFilesRoutes();
        $this->mapApiClassesRoutes();
        $this->mapApiAnalyticsRoutes();

        $this->mapAdminRoutes();
        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->namespace($this->namespace.'\Admin')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace.'\Api')
             ->group(base_path('routes/api.php'));
    }

    /*
     * IMBaaS API routes
     */

    protected function mapApiUsersRoutes()
    {
        Route::prefix('api')
            ->middleware('api_users')
            ->namespace($this->namespace.'\Api\Users')
            ->group(base_path('routes/users_api.php'));
    }

    protected function mapApiSessionsRoutes()
    {
        Route::prefix('api')
            ->middleware('api_sessions')
            ->namespace($this->namespace.'\Api\Sessions')
            ->group(base_path('routes/sessions_api.php'));
    }

    protected function mapApiRolesRoutes()
    {
        Route::prefix('api')
            ->middleware('api_roles')
            ->namespace($this->namespace.'\Api\Roles')
            ->group(base_path('routes/roles_api.php'));
    }

    protected function mapApiPushsRoutes()
    {
        Route::prefix('api')
            ->middleware('api_pushs')
            ->namespace($this->namespace.'\Api\Pushs')
            ->group(base_path('routes/pushs_api.php'));
    }

    protected function mapApiInstallationsRoutes()
    {
        Route::prefix('api')
            ->middleware('api_installations')
            ->namespace($this->namespace.'\Api\Installations')
            ->group(base_path('routes/installations_api.php'));
    }

    protected function mapApiFilesRoutes()
    {
        Route::prefix('api')
            ->middleware('api_files')
            ->namespace($this->namespace.'\Api\Files')
            ->group(base_path('routes/files_api.php'));
    }

    protected function mapApiClassesRoutes()
    {
        Route::prefix('api')
            ->middleware('api_classes')
            ->namespace($this->namespace.'\Api\Classes')
            ->group(base_path('routes/classes_api.php'));
    }

    protected function mapApiAnalyticsRoutes()
    {
        Route::prefix('api')
            ->middleware('api_analytics')
            ->namespace($this->namespace.'\Api\Analytics')
            ->group(base_path('routes/analytics_api.php'));
    }

    protected function mapApiSchemasRoutes()
    {
        Route::prefix('api')
            ->middleware('api_schemas')
            ->namespace($this->namespace.'\Api\Schemas')
            ->group(base_path('routes/schemas_api.php'));
    }
}
