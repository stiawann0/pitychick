<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Route::middlewareGroup('admin', [\App\Http\Middleware\AdminMiddleware::class]);
        Route::middlewareGroup('customer', [\App\Http\Middleware\EnsureIsCustomer::class]);
        Route::middlewareGroup('permission', [\Spatie\Permission\Middlewares\PermissionMiddleware::class]);
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
