<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes — Sistem Pencatatan Keuangan Karang Taruna
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])->name('demo.login');
});

// Auth
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pemasukan — read: semua; write: admin/pengurus
    Route::get('/pemasukan', [KeuanganController::class, 'pemasukan'])->name('pemasukan.index');

    // Pengeluaran — read: semua; write: admin/pengurus
    Route::get('/pengeluaran', [KeuanganController::class, 'pengeluaran'])->name('pengeluaran.index');

    // Laporan Keuangan — bisa dilihat semua, export hanya admin
    Route::get('/laporan', [KeuanganController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [KeuanganController::class, 'exportPdf'])->name('laporan.exportPdf');

    // Write routes — khusus admin/pengurus
    Route::middleware(['role:admin|Ketua|Sekretaris|Bendahara'])->group(function () {
        // Tambah Pemasukan
        Route::get('/pemasukan/tambah', [KeuanganController::class, 'createPemasukan'])->name('pemasukan.create');
        Route::post('/pemasukan', [KeuanganController::class, 'storePemasukan'])->name('pemasukan.store');
        Route::get('/pemasukan/{keuangan}/edit', [KeuanganController::class, 'edit'])->name('pemasukan.edit');
        Route::put('/pemasukan/{keuangan}', [KeuanganController::class, 'update'])->name('pemasukan.update');
        Route::delete('/pemasukan/{keuangan}', [KeuanganController::class, 'destroy'])->name('pemasukan.destroy');

        // Tambah Pengeluaran
        Route::get('/pengeluaran/tambah', [KeuanganController::class, 'createPengeluaran'])->name('pengeluaran.create');
        Route::post('/pengeluaran', [KeuanganController::class, 'storePengeluaran'])->name('pengeluaran.store');
        Route::get('/pengeluaran/{keuangan}/edit', [KeuanganController::class, 'editPengeluaran'])->name('pengeluaran.edit');
        Route::put('/pengeluaran/{keuangan}', [KeuanganController::class, 'updatePengeluaran'])->name('pengeluaran.update');
        Route::delete('/pengeluaran/{keuangan}', [KeuanganController::class, 'destroyPengeluaran'])->name('pengeluaran.destroy');

        // Export Excel dari laporan
        Route::get('/laporan/export-excel', [KeuanganController::class, 'exportExcel'])->name('laporan.exportExcel');
    });
});
