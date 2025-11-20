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
use App\Http\Controllers\Api\ProfileController; 
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Middleware\CustomerMiddleware;

Route::get('/test-without-sb', function () {
    try {
        // ✅ AMAN - Pakai environment variable
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$clientKey = config('midtrans.client_key');
        
        $params = [
            'transaction_details' => [
                'order_id' => 'NO-SB-TEST-' . time(),
                'gross_amount' => 10000,
            ]
        ];
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        return response()->json([
            'success' => true,
            'message' => 'Test without SB prefix using environment variables',
            'snap_token' => $snapToken,
            'config_source' => 'environment_variables'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'config_source' => 'environment_variables'
        ], 500);
    }
});

// Debug route untuk test Midtrans configuration
Route::get('/debug/midtrans', function () {
    try {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$clientKey = config('midtrans.client_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        
        $params = [
            'transaction_details' => [
                'order_id' => 'TEST-' . time(),
                'gross_amount' => 10000,
            ]
        ];
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        return response()->json([
            'success' => true,
            'message' => 'Midtrans configuration is correct',
            'snap_token' => $snapToken,
            'config' => [
                'server_key_set' => !empty(config('midtrans.server_key')),
                'client_key_set' => !empty(config('midtrans.client_key')),
                'merchant_id_set' => !empty(config('midtrans.merchant_id')),
                'is_production' => config('midtrans.is_production'),
                'environment' => config('midtrans.is_production') ? 'production' : 'sandbox'
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Midtrans Error: ' . $e->getMessage(),
            'config' => [
                'server_key_set' => !empty(config('midtrans.server_key')),
                'client_key_set' => !empty(config('midtrans.client_key')),
                'merchant_id_set' => !empty(config('midtrans.merchant_id')),
                'is_production' => config('midtrans.is_production'),
                'environment' => config('midtrans.is_production') ? 'production' : 'sandbox'
            ]
        ], 500);
    }
});

// Health check route untuk deployment
Route::get('/health-check', function() {
    return response()->json([
        'status' => 'OK',
        'service' => 'Pity Chick Backend API',
        'timestamp' => now()->toDateTimeString(),
        'environment' => config('app.env'),
        'debug_mode' => config('app.debug')
    ]);
});

// --------------------------------------------------------
// 🔓 PUBLIC ROUTES (Tidak perlu login)
// --------------------------------------------------------
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

// Midtrans Public Routes
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler']);
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess']);
Route::get('/payment/failed', [PaymentController::class, 'paymentFailed']);
Route::get('/payment/pending', [PaymentController::class, 'paymentPending']);

// --------------------------------------------------------
// 🔒 AUTH ROUTES (Harus login)
// --------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // --------------------------------------------------------
    // 👥 CUSTOMER ONLY ROUTES
    // --------------------------------------------------------
    Route::middleware(CustomerMiddleware::class)->group(function () {

        // Reservations
        Route::get('/my-reservations', [ReservationController::class, 'myReservations']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::post('/walk-in', [ReservationController::class, 'walkIn']);
        Route::get('/tables/available', [TableController::class, 'available']);
        Route::apiResource('reservations', ReservationController::class)->except(['store']);
        Route::get('/daily-report', [ReservationController::class, 'dailyReport']);
        Route::apiResource('tables', TableController::class);
        Route::apiResource('menus', MenuController::class)->except(['index', 'show']);

        // Orders
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{orderId}', [OrderController::class, 'show']);
        Route::post('/orders/{orderId}/cancel', [OrderController::class, 'cancel']);

        // Payments
        Route::post('/midtrans/create-transaction', [PaymentController::class, 'createMidtransTransaction']);
        Route::get('/payments/{orderId}/status', [PaymentController::class, 'checkPaymentStatus']);

        // Profiles
        Route::get('/profiles', [ProfileController::class, 'index']);
        Route::post('/profiles', [ProfileController::class, 'store']);
        Route::put('/profiles/{id}', [ProfileController::class, 'update']);
        Route::delete('/profiles/{id}', [ProfileController::class, 'destroy']);
        Route::patch('/profiles/{id}/default', [ProfileController::class, 'setDefault']);
    });
});