<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController; // 🔥 PASTIKAN IMPORT INI
use App\Http\Controllers\Admin\Settings\HomeSettingsController;
use App\Http\Controllers\Admin\Settings\AboutSettingsController;
use App\Http\Controllers\Admin\Settings\ReviewSettingsController;
use App\Http\Controllers\Admin\Settings\FooterSettingsController;
use App\Http\Controllers\Admin\Settings\GallerySettingsController;

// ==========================================
// ✅ PUBLIC ROUTES
// ==========================================
Route::get('/', fn () => view('welcome'))->name('home');

// Register & Login
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// ==========================================
// ✅ AUTHENTICATED ROUTES (SETELAH LOGIN)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard umum
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    

    // ========================
    // ✅ ADMIN PANEL - FIXED STRUCTURE
    // ========================
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard - accessible by all authenticated admin users
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 🔥 PERBAIKI: ROUTE CHART DENGAN NAMA YANG BENAR
        Route::get('/dashboard/orders-chart', [DashboardController::class, 'getOrderChartData'])
            ->name('dashboard.ordersChart'); // 🔥 NAMA ROUTE YANG BENAR
        
        Route::get('/dashboard/reservations-chart', [DashboardController::class, 'getReservationChartData'])
            ->name('dashboard.reservationsChart'); // 🔥 NAMA ROUTE YANG BENAR

        // 🔥 UPDATE ROUTE UNTUK ORDERS - TAMBAH ROUTE BARU
        Route::middleware('can:manage-orders')->group(function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
            
            // 🔥 ROUTES BARU UNTUK QUICK ACTIONS
            Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
            Route::post('/orders/{order}/process', [OrderController::class, 'process'])->name('orders.process');
            Route::post('/orders/{order}/deliver', [OrderController::class, 'deliver'])->name('orders.deliver');
            Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
            Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        });

        // ✅ RESERVATIONS - dengan permission spesifik
        Route::middleware('can:manage-reservations')->group(function () {
            Route::resource('reservations', ReservationController::class);
            Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])
                ->name('reservations.confirm');
            Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
                ->name('reservations.cancel');
        });

        // ✅ TABLES - dengan permission spesifik
        Route::middleware('can:manage-tables')->group(function () {
            Route::resource('tables', TableController::class);
        });

        // ✅ MENUS - dengan permission spesifik
        Route::middleware('can:manage-menus')->group(function () {
            Route::resource('menus', MenuController::class);
        });

        // ✅ USERS - dengan permission spesifik
        Route::middleware('can:manage-users')->group(function () {
            Route::resource('users', UserController::class);
        });

        // Dalam group admin orders
        Route::middleware('can:manage-orders')->group(function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
            
            // Quick Actions - PERBAIKI ROUTE UNTUK JAVASCRIPT
            Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
            Route::post('/orders/{order}/process', [OrderController::class, 'process'])->name('orders.process');
            Route::post('/orders/{order}/deliver', [OrderController::class, 'deliver'])->name('orders.deliver');
            Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
            
            // 🔥 ROUTE BARU UNTUK JAVASCRIPT ACTION
            Route::post('/orders/{order}/{action}', [OrderController::class, 'updateStatus'])->name('orders.action');
            
            // COD Payment
            Route::post('/orders/{order}/complete-cod-payment', [OrderController::class, 'completeCodPayment'])->name('orders.complete-cod-payment');
            Route::post('/orders/{order}/mark-as-paid', [OrderController::class, 'markAsPaid'])->name('orders.mark-as-paid');
            
            // Unpaid COD
            Route::get('/orders/unpaid-cod', [OrderController::class, 'getDeliveredUnpaidCOD'])->name('orders.unpaid-cod');
        });

        // ✅ SETTINGS - dengan permission spesifik
        Route::prefix('settings')->name('settings.')->middleware('can:manage-settings')->group(function () {
            Route::view('/', 'admin.settings.index')->name('index');
            Route::get('/home', [HomeSettingsController::class, 'index'])->name('home');
            Route::match(['post', 'put'], '/home', [HomeSettingsController::class, 'update'])->name('home.update');
            Route::get('/footer', [FooterSettingsController::class, 'index'])->name('footer');
            Route::post('/footer', [FooterSettingsController::class, 'update'])->name('footer.update');
            Route::get('/reviews', [ReviewSettingsController::class, 'index'])->name('reviews');
            Route::post('/reviews', [ReviewSettingsController::class, 'store'])->name('reviews.store');
            Route::delete('/reviews/{id}', [ReviewSettingsController::class, 'destroy'])->name('reviews.destroy');
            Route::get('/about', [AboutSettingsController::class, 'index'])->name('about');
            Route::post('/about', [AboutSettingsController::class, 'update'])->name('about.update');
            Route::get('/gallery', [GallerySettingsController::class, 'index'])->name('gallery');
            Route::post('/gallery', [GallerySettingsController::class, 'store'])->name('gallery.store');
            Route::delete('/gallery/{gallery}', [GallerySettingsController::class, 'destroy'])->name('gallery.destroy');
        });
    });
});

require __DIR__ . '/auth.php';