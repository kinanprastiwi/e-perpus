<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes - Authentication
Route::post('/register', [RegisterController::class, 'register']); // ✅ GUNAKAN INI
Route::post('/login', [ApiAuthController::class, 'login']);

// Public routes - Books & Categories (buku yang tersedia untuk dipinjam)
Route::get('/public/books', [BukuController::class, 'publicIndex']);
Route::get('/public/books/{id}', [BukuController::class, 'publicShow']);
Route::get('/public/categories', [KategoriController::class, 'publicIndex']);

// Route yang membutuhkan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    
    // User management (hanya admin/petugas)
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{kode_user}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{kode_user}', [UserController::class, 'update']);
        Route::delete('/users/{kode_user}', [UserController::class, 'destroy']);
        Route::patch('/users/{kode_user}/verify', [UserController::class, 'verify']);
        Route::get('/users/search/{keyword}', [UserController::class, 'search']);
    });

    // Book management
    Route::apiResource('books', BukuController::class);
    Route::get('/books/search/{keyword}', [BukuController::class, 'search']);
    
    // Category management
    Route::apiResource('categories', KategoriController::class);
    
    // Loan management
    Route::apiResource('loans', PeminjamanController::class);
    Route::patch('/loans/{id}/return', [PeminjamanController::class, 'returnBook']);
    Route::get('/user/loans', [PeminjamanController::class, 'userLoans']);
    Route::get('/loans/search/{keyword}', [PeminjamanController::class, 'search']);
    
    // Dashboard stats (hanya admin/petugas)
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/dashboard/stats', [PeminjamanController::class, 'dashboardStats']);
        Route::get('/dashboard/recent-loans', [PeminjamanController::class, 'recentLoans']);
        Route::get('/dashboard/popular-books', [BukuController::class, 'popularBooks']);
    });
});

// Fallback route untuk API yang tidak ditemukan
Route::fallback(function () {
    return response()->json([
        'message' => 'API endpoint not found.'
    ], 404);
});