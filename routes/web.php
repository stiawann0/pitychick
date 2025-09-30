<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Settings\HomeSettingsController;
use App\Http\Controllers\Admin\Settings\AboutSettingsController;
use App\Http\Controllers\Admin\Settings\ReviewSettingsController;
use App\Http\Controllers\Admin\Settings\FooterSettingsController;
use App\Http\Controllers\Admin\Settings\GallerySettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// ==========================================
// ✅ DEBUG & MAINTENANCE ROUTES (TEMPORARY)
// ==========================================

// Untuk test koneksi database
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'success',
            'message' => '✅ Database connected!',
            'database' => DB::connection()->getDatabaseName()
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => '❌ DB connection failed: ' . $e->getMessage()
        ]);
    }
});

// Jalankan migration
Route::get('/migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return '✅ Migration completed';
});

// Jalankan seeding
Route::get('/seed', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return '✅ Seeding completed';
});

// Reset database + seeding
Route::get('/reset-db', function () {
    Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    return '✅ Database reset & seeded';
});

// Clear + cache config/view/route
Route::get('/cache-clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return '✅ Cache cleared!';
});

Route::get('/cache-optimize', function () {
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return '✅ Cache optimized!';
});

// Test App Jalan
Route::get('/health', fn () => response()->json([
    'app' => 'Laravel',
    'version' => app()->version(),
    'env' => app()->environment(),
    'url' => config('app.url'),
    'debug' => config('app.debug')
]));

// ==========================================
// ✅ PUBLIC ROUTES
// ==========================================

// Homepage (akan diganti React)
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
    // ✅ ADMIN PANEL
    // ========================
    Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Reservations
        Route::resource('reservations', ReservationController::class);
        Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
        Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

        // Tables
        Route::resource('tables', TableController::class);

        // Menus
        Route::resource('menus', MenuController::class);

        // Users
        Route::resource('users', UserController::class);

        // ========================
        // ✅ SETTINGS
        // ========================
        Route::prefix('settings')->name('settings.')->group(function () {
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

// ==========================================
// ✅ INCLUDE AUTH (Breeze / Fortify)
// ==========================================
require __DIR__ . '/auth.php';
