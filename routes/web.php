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
    Route::prefix('admin')->name('admin.')->middleware('can:manage-settings')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Reservations
        Route::resource('reservations', ReservationController::class)->middleware('can:manage-reservations');
        Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm')->middleware('can:manage-reservations');
        Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel')->middleware('can:manage-reservations');

        // Tables
        Route::resource('tables', TableController::class)->middleware('can:manage-tables');

        // Menus
        Route::resource('menus', MenuController::class)->middleware('can:manage-menus');

        // Users
        Route::resource('users', UserController::class)->middleware('can:manage-users');

        // ========================
        // ✅ SETTINGS
        // ========================
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

// ==========================================
// ✅ INCLUDE AUTH (Breeze / Fortify)
// ==========================================
require __DIR__ . '/auth.php';