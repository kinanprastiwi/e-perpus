<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserDashboardController;

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

// Authentication Routes - PASTIKAN NAMA CONTROLLER BENAR
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Route register (opsional)
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

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

    // Admin routes
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return 'Dashboard Admin - Role: ' . auth()->user()->role;
        })->name('admin.dashboard');
    });
    
    // User routes
    Route::middleware(['role:anggota'])->group(function () {
        Route::get('/user/dashboard', function () {
            return 'Dashboard User - Role: ' . auth()->user()->role;
        })->name('user.dashboard');
        
        Route::get('/user/peminjaman', function () {
            return 'Peminjaman User';
        })->name('user.peminjaman');
        
        Route::get('/user/pengembalian', function () {
            return 'Pengembalian User';
        })->name('user.pengembalian');
        
        Route::get('/user/buku', function () {
            return 'Daftar Buku';
        })->name('user.buku');
        
        Route::get('/user/profil', function () {
            return 'Profil User';
        })->name('user.profil');
    });
});