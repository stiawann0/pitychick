<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Daftarkan route API di sini
        Route::prefix('api')
            ->middleware('api')
            ->group(function () {
                // Route publik
                Route::get('/menus', [\App\Http\Controllers\Api\MenuController::class, 'index']);

                // Route yang perlu autentikasi token sanctum
                Route::middleware('auth:sanctum')->group(function () {
                    Route::get('/user', function () {
                        return auth()->user();
                    });

                    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

                    Route::apiResource('menus', \App\Http\Controllers\Api\MenuController::class)->except(['index']);
                    // Tambah route lainnya sesuai kebutuhan
                });
            });
    }
}
