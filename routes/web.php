<?php

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
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

// Public Homepage
Route::get('/', function () {
    return Redirect::to('http://localhost:5173');
})->name('home');

// Auth routes (harus di luar middleware auth)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // User Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes Group
    Route::prefix('admin')->name('admin.')->middleware('auth', 'verified', 'can:admin')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Reservation Management
        Route::resource('reservations', ReservationController::class);
        Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])
            ->name('reservations.confirm');
        Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
            ->name('reservations.cancel');
        
        // Table Management
        Route::resource('tables', TableController::class);
        
        // Menu Management
        Route::resource('menus', MenuController::class);
        
        // User Management
        Route::resource('users', UserController::class)->names([
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'update' => 'users.update',
            'destroy' => 'users.destroy'
        ]);
        
        // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::view('/', 'admin.settings.index')->name('index');

        Route::get('/home', [HomeSettingsController::class, 'index'])->name('home');
        Route::post('/home', [HomeSettingsController::class, 'update'])->name('home.update');
        Route::put('/home', [HomeSettingsController::class, 'update'])->name('home.update');

        Route::get('/footer', [FooterSettingsController::class, 'index'])->name('footer');
        Route::post('/footer', [FooterSettingsController::class, 'update'])->name('footer.update');

        Route::get('/reviews', [ReviewSettingsController::class, 'index'])->name('reviews');
        Route::post('/reviews', [ReviewSettingsController::class, 'store'])->name('reviews.store');
        Route::delete('/reviews/{id}', [ReviewSettingsController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/about', [AboutSettingsController::class, 'index'])->name('about');
        Route::post('/about', [AboutSettingsController::class, 'update'])->name('about.update');

        Route::get('gallery', [GallerySettingsController::class, 'index'])->name('gallery');
        Route::post('gallery', [GallerySettingsController::class, 'store'])->name('gallery.store');
        Route::delete('gallery/{gallery}', [GallerySettingsController::class, 'destroy'])->name('gallery.destroy');
    });
        
    });
});

// Authentication Routes
require __DIR__.'/auth.php';
