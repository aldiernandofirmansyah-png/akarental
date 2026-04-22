<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;

// ==================== HALAMAN DEPAN ====================
Route::get('/landing', [LandingController::class, 'index'])->name('landing');

// ==================== ROUTE ADMIN ====================
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/data-pelanggan', [AdminController::class, 'dataPelanggan'])->name('admin.data_pelanggan');
    Route::get('/riwayat-sewa', [AdminController::class, 'riwayatSewa'])->name('admin.riwayat_sewa');
});

// ==================== ROUTE PELANGGAN ====================
Route::prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::get('/riwayat-sewa', [PelangganController::class, 'riwayatSewa'])->name('pelanggan.riwayat_sewa');
    Route::get('/perpanjangan/{id}', [PelangganController::class, 'perpanjangan'])->name('pelanggan.perpanjangan');
});