<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\PeminjamanController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Data Management
    Route::resource('anggota', AnggotaController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('administrator', AdministratorController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    
    // Home redirect
    Route::get('/', function () {
        return redirect('/dashboard');
    });
});