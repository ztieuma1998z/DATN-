<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

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

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
        $this->mapTeacherRoutes();
        $this->mapStudentRoutes();
        $this->mapAuthRoutes();

        //
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
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

//  Custom routers

    /**
     * Định nghĩa router "admin"
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Định nghĩa router "student"
     *
     * @return void
     */
    protected function mapStudentRoutes()
    {
        Route::middleware('student')
            ->namespace($this->namespace)
            ->group(base_path('routes/student.php'));
    }

    /**
     * Định nghĩa router "teacher"
     *
     * @return void
     */
    protected function mapTeacherRoutes()
    {
        Route::middleware('teacher')
            ->namespace($this->namespace)
            ->group(base_path('routes/teacher.php'));
    }

    /**
     * Định nghĩa router "auth"
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::middleware('auth')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth.php'));
    }
}
