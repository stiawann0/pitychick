<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\HomeSettingsController;
use App\Http\Controllers\Api\NavigationSettingsController;
use App\Http\Controllers\Api\AboutSettingsController;
use App\Http\Controllers\Api\GallerySettingsController;
use App\Http\Controllers\Api\ReviewSettingsController;
use App\Http\Controllers\Api\FooterSettingsController;
use App\Http\Middleware\CustomerMiddleware;

/// Public routes (register, login, view menus)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{menu}', [MenuController::class, 'show']);
Route::get('/home', [HomeSettingsController::class, 'index']);
Route::get('/navigation', [NavigationSettingsController::class, 'index']);
Route::get('/about', [AboutSettingsController::class, 'index']);
Route::get('/gallery', [GallerySettingsController::class, 'index']);
Route::get('/reviews', [ReviewSettingsController::class, 'index']);
Route::get('/footer', [FooterSettingsController::class, 'index']);

// Routes for authenticated users (customer and admin)
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // Customer only routes
    Route::middleware(CustomerMiddleware::class)->group(function () {
        Route::get('/my-reservations', [ReservationController::class, 'myReservations']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::post('/walk-in', [ReservationController::class, 'walkIn']);
        Route::get('/tables/available', [TableController::class, 'available']);
        Route::apiResource('reservations', ReservationController::class)->except(['store']);
        Route::get('/daily-report', [ReservationController::class, 'dailyReport']);
        Route::apiResource('tables', TableController::class);
        Route::apiResource('menus', MenuController::class)->except(['index', 'show']);

    });
});
