<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

    // ✅ ADMIN ROUTES
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::get('/admin/dashboard', function () {
            // Ambil data stats
            $stats = [
                'anggota_count' => \App\Models\User::where('role', 'anggota')->count(),
                'buku_count' => \App\Models\Buku::count(),
                'kategori_count' => \App\Models\Kategori::count(),
                'penerbit_count' => \App\Models\Penerbit::count(),
                'peminjaman_aktif_count' => \App\Models\Peminjaman::where('status', 'Dipinjam')->count(),
                'pengembalian_count' => \App\Models\Peminjaman::where('status', 'Dikembalikan')->count(),
            ];

            // Ambil data peminjaman terbaru
            $recentLoans = \App\Models\Peminjaman::with(['user', 'buku'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('admin.dashboard', compact('stats', 'recentLoans'));
        })->name('admin.dashboard');
        
        // Tambahkan routes admin lainnya di sini nanti
        // Route::get('/admin/anggota', ...);
        // Route::get('/admin/buku', ...);
    });

    // ✅ USER ROUTES  
    Route::middleware(['role:anggota'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');
        
        Route::get('/user/peminjaman', function () {
            return view('user.peminjaman');
        })->name('user.peminjaman');
        
        Route::get('/user/pengembalian', function () {
            return view('user.pengembalian');
        })->name('user.pengembalian');
        
        Route::get('/user/buku', function () {
            return view('user.buku');
        })->name('user.buku');
        
        Route::get('/user/profil', function () {
            return view('user.profil');
        })->name('user.profil');
    });
});