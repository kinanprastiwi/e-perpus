<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenerbitController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use App\Http\Controllers\User\BukuController as UserBukuController;

// Debug routes
Route::get('/debug-role', function () {
    $checkRoleExists = class_exists('App\Http\Middleware\CheckRole');
    $middlewares = app('router')->getMiddleware();
    
    return response()->json([
        'checkrole_class_exists' => $checkRoleExists,
        'registered_middlewares' => array_keys($middlewares),
        'role_middleware_registered' => isset($middlewares['role']),
        'file_exists' => file_exists(app_path('Http/Middleware/CheckRole.php')),
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Debug route
Route::get('/debug-session', function() {
    echo "Session ID: " . session()->getId() . "<br>";
    echo "Auth check: " . (auth()->check() ? 'YES' : 'NO') . "<br>";
    if (auth()->check()) {
        echo "User: " . auth()->user()->username . "<br>";
        echo "Role: " . auth()->user()->role . "<br>";
    }
    echo "<pre>";
    print_r(session()->all());
    echo "</pre>";
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', function () {
        $user = auth()->user();
        if (in_array($user->role, ['admin', 'petugas'])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/user/dashboard');
        }
    })->name('home');

    // Test route
    Route::get('/test-simple', function () {
        return 'Auth berhasil! Role: ' . auth()->user()->role;
    });

    // ✅ ADMIN ROUTES
    Route::prefix('admin')->name('admin.')->middleware(['role:admin,petugas'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/chart-data', [DashboardController::class, 'getChartData'])->name('chart.data');
        
        // Anggota routes
        Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
        Route::post('/anggota/{anggota}/toggle-status', [AnggotaController::class, 'toggleStatus'])->name('anggota.toggleStatus');
        Route::resource('/anggota', AnggotaController::class);
        
        // Buku routes
        Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
        Route::post('/buku/{buku}/stock', [BukuController::class, 'updateStock'])->name('buku.stock.update');
        Route::resource('/buku', BukuController::class);
        
        // Kategori routes
        Route::resource('/kategori', KategoriController::class);
        
        // Penerbit routes
        Route::resource('/penerbit', PenerbitController::class);
        
        // ✅ PEMINJAMAN ROUTES
        Route::resource('peminjaman', PeminjamanController::class);
        Route::post('peminjaman/{peminjaman}/return', [PeminjamanController::class, 'returnBook'])
             ->name('peminjaman.return');
        Route::post('peminjaman/{peminjaman}/extend', [PeminjamanController::class, 'extendDueDate'])
             ->name('peminjaman.extend');
    });

  // ✅ USER ROUTES - FIXED
Route::prefix('user')->name('user.')->middleware(['role:anggota'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // ROUTE BUKU
    Route::get('/buku', [UserBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [UserBukuController::class, 'show'])->name('buku.show');
    
    // ROUTE PEMINJAMAN - PASTIKAN NAME BENAR
    Route::post('/buku/{id}/pinjam', [UserPeminjamanController::class, 'pinjam'])
        ->name('buku.pinjam'); // user.buku.pinjam
    
    Route::get('/peminjaman', [UserPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [UserPeminjamanController::class, 'show'])->name('peminjaman.show');
    
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::put('/profil', [UserController::class, 'updateProfil'])->name('profil.update');
});
});