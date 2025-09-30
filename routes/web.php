<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB; // <- TAMBAHKAN INI
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

// =============================
// ✅ DATABASE TEST ROUTES - TAMBAHKAN INI
// =============================
Route::get('/db-test', function() {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'success', 
            'message' => '✅ Database connected successfully!',
            'database' => DB::connection()->getDatabaseName()
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => '❌ Database connection failed: ' . $e->getMessage()
        ]);
    }
});

Route::get('/run-migrate', function() {
    try {
        Artisan::call('migrate --force');
        return response()->json([
            'status' => 'success', 
            'message' => '✅ Migration completed successfully!'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => '❌ Migration failed: ' . $e->getMessage()
        ]);
    }
});

Route::get('/db-status', function() {
    try {
        $pdo = DB::connection()->getPdo();
        $tables = DB::select('SHOW TABLES');
        
        return response()->json([
            'status' => 'success',
            'database' => DB::connection()->getDatabaseName(),
            'tables_count' => count($tables),
            'tables' => $tables
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
});

// =============================
// ✅ TEST ROUTES UNTUK RAILWAY (TANPA DATABASE)
// =============================
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'App is running without database',
        'timestamp' => now(),
        'environment' => app()->environment()
    ]);
});

Route::get('/health', function () {
    return response()->json([
        'app' => 'Laravel',
        'version' => app()->version(),
        'environment' => app()->environment(),
        'url' => config('app.url'),
        'debug' => config('app.debug')
    ]);
});

// Route test untuk check session
Route::get('/session-test', function () {
    return response()->json([
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ]);
});

// =============================
// ✅ Public Homepage
// =============================
Route::get('/', function () {
    return view('welcome'); // Ganti dengan React frontend jika sudah deploy
})->name('home');

// =============================
// ✅ Temporary routes untuk Railway (Fix 500 Error)
// =============================
// Hanya untuk sekali pakai! Hapus setelah selesai.
Route::get('/run-migration', function() {
    Artisan::call('migrate', ["--force"=>true]);
    Artisan::call('db:seed', ["--force"=>true]);
    return 'Migration & seeding done';
});

// ✅ TAMBAHKAN INI - Untuk reset database lengkap
Route::get('/db-reset', function() {
    Artisan::call('migrate:fresh --seed --force');
    return 'Database reset complete dengan data fresh!';
});

// ✅ Untuk jalankan migration baru saja
Route::get('/add-admin-role', function() {
    Artisan::call('migrate --force');
    return 'Migration untuk role admin berhasil dijalankan!';
});

// ✅ Untuk jalankan migration tanpa seeding
Route::get('/migrate-only', function() {
    Artisan::call('migrate --force');
    return 'Migration berhasil! Sekarang jalankan /seed-only untuk seeding.';
});

// ✅ Untuk jalankan seeding saja
Route::get('/seed-only', function() {
    Artisan::call('db:seed --force');
    return 'Seeding berhasil!';
});

Route::get('/run-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'Config, route & view cached';
});

Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'Cache cleared and config re-cached!';
});

Route::get('/debug-db', function() {
    return response()->json([
        'db_connection' => config('database.default'),
        'db_host' => config('database.connections.mysql.host'),
        'db_port' => config('database.connections.mysql.port'),
        'env_db_connection' => env('DB_CONNECTION'),
        'env_db_host' => env('DB_HOST')
    ]);
});
// =============================
// ✅ Auth routes (register, login)
// =============================
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// =============================
// ✅ Routes dengan Auth + Verifikasi Email
// =============================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ✅ User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Dashboard umum
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =============================
    // ✅ Admin Group
    // =============================
    Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Reservation Management
        Route::resource('reservations', ReservationController::class);
        Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
        Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

        // Table Management
        Route::resource('tables', TableController::class);

        // Menu Management
        Route::resource('menus', MenuController::class);

        // User Management
        Route::resource('users', UserController::class)->names([
            'index'   => 'users.index',
            'create'  => 'users.create',
            'store'   => 'users.store',
            'show'    => 'users.show',
            'edit'    => 'users.edit',
            'update'   => 'users.update',
            'destroy' => 'users.destroy',
        ]);

        // =============================
        // Settings Group
        // =============================
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

// =============================
// ✅ Include Auth Scaffolding (Breeze/Fortify/etc.)
// =============================
require __DIR__.'/auth.php';