<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==================== HALAMAN DEPAN ====================
// URL: /
Route::get('/', [LandingController::class, 'index'])->name('landing');
// URL: /landing
Route::get('/landing', [LandingController::class, 'index']);

// ==================== LOGIN ADMIN (Halaman Khusus) ====================
Route::get('/admin-login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login')->middleware('guest');
Route::post('/admin-login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit')->middleware('guest');

// ==================== REDIRECT DASHBOARD ====================
// URL: /dashboard (Redirect otomatis sesuai role)
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user instanceof \App\Models\User && $user->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    return redirect('/pelanggan/dashboard');
})->middleware(['auth'])->name('dashboard');

// ==================== GROUP ADMIN ====================
// Semua URL di bawah ini diawali dengan /admin/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    Route::get('/admin/manajemen-barang', [AdminController::class, 'manajemenBarang'])->name('admin.manajemen_barang');
    Route::post('/admin/barang/store', [AdminController::class, 'storeBarang'])->name('admin.barang.store');
    Route::put('/admin/barang/update/{id}', [AdminController::class, 'updateBarang'])->name('admin.barang.update');
    Route::delete('/admin/barang/delete/{id}', [AdminController::class, 'destroyBarang'])->name('admin.barang.delete');
    
    Route::get('/admin/konfirmasi-booking', [AdminController::class, 'konfirmasiBooking'])->name('admin.konfirmasi_booking');
    Route::get('/admin/riwayat-sewa', [AdminController::class, 'riwayatSewaFinal'])->name('admin.riwayat_sewa');
    
    Route::put('/admin/sewa/konfirmasi-dp/{id}', [AdminController::class, 'konfirmasiDP'])->name('admin.sewa.konfirmasi_dp');
    Route::put('/admin/sewa/mulai/{id}', [AdminController::class, 'mulaiSewa'])->name('admin.sewa.mulai');
    Route::put('/admin/sewa/selesai/{id}', [AdminController::class, 'selesaiSewa'])->name('admin.sewa.selesai');
});

// ==================== GROUP PELANGGAN ====================
// Semua URL di bawah ini diawali dengan /pelanggan/
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::post('/pelanggan/booking/store', [PelangganController::class, 'storeBooking'])->name('pelanggan.booking.store');
    Route::get('/pelanggan/riwayat-sewa', [PelangganController::class, 'riwayatSewa'])->name('pelanggan.riwayat_sewa');
    Route::get('/pelanggan/perpanjangan/{id}', [PelangganController::class, 'perpanjangan'])->name('pelanggan.perpanjangan');
    Route::post('/pelanggan/perpanjangan/{id}', [PelangganController::class, 'storePerpanjangan'])->name('pelanggan.perpanjangan.store');
});

// ==================== PROFILE (BREEZE) ====================
// Fitur profile telah dinonaktifkan karena tidak digunakan.

require __DIR__.'/auth.php';
