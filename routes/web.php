<?php

use App\Http\Controllers\Guest\BerandaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Route Publik (Landing Page & Kontak)
Route::get('/', [BerandaController::class, 'index'])->name('home');
Route::get('/bidang/{bidang}', [\App\Http\Controllers\Guest\BidangDetailController::class, 'show'])->name('bidang.show');
Route::get('/bidang/{bidang}/daftar', function(\App\Models\Bidang $bidang) {
    session(['bidang_id' => $bidang->id]);
    return redirect()->route('login');
})->name('bidang.daftar');
Route::get('/kontak', function () {
    return view('guest.kontak');
})->name('kontak');

// Google OAuth Routes
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Fallback route 'dashboard' used by Breeze auth controllers (VerifyEmail, etc.)
// Redirects based on user's assigned role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('Administrator')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Petugas')) {
        return redirect()->route('petugas.dashboard');
    }
    if (session()->has('bidang_id')) {
        return redirect()->route('pengguna.career.step1', ['bidang_id' => session('bidang_id')]);
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// 2. Route Pengguna (Magang/PKL Applicants)
Route::middleware(['auth', 'role:Pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Pengguna\DashboardController::class, 'index'])->name('dashboard');

    // Career Form 2-step wizard
    Route::prefix('career')->name('career.')->group(function () {
        Route::get('/step1',   [\App\Http\Controllers\Pengguna\CareerController::class, 'step1'])->name('step1');
        Route::post('/step1',  [\App\Http\Controllers\Pengguna\CareerController::class, 'step1Store'])->name('step1.store');
        Route::get('/step2',   [\App\Http\Controllers\Pengguna\CareerController::class, 'step2'])->name('step2');
        Route::post('/step2',  [\App\Http\Controllers\Pengguna\CareerController::class, 'storeFinal'])->name('store');
        Route::get('/konfirmasi/{public_id}', [\App\Http\Controllers\Pengguna\CareerController::class, 'konfirmasi'])->name('konfirmasi');
        // API endpoint for Alpine.js calendar
        Route::get('/api/kuota/{bidang}', [\App\Http\Controllers\Pengguna\CareerController::class, 'kuotaKalender'])->name('api.kuota');
    });

    // Post-Approval Gate (SKM)
    Route::prefix('gate/{pengajuan}')->name('gate.')->group(function () {
        Route::get('/skm', [\App\Http\Controllers\Pengguna\GateController::class, 'showSkm'])->name('skm');
        Route::post('/skm', [\App\Http\Controllers\Pengguna\GateController::class, 'storeSkm'])->name('skm.store');
    });

    // Riwayat Pengajuan
    Route::get('/riwayat', [\App\Http\Controllers\Pengguna\RiwayatController::class, 'index'])->name('riwayat');

    // Detail & Cancel Pengajuan
    Route::get('/pengajuan/{public_id}', [\App\Http\Controllers\Pengguna\DetailPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{public_id}/batal', [\App\Http\Controllers\Pengguna\DetailPengajuanController::class, 'cancel'])->name('pengajuan.cancel');

    // Unggah Laporan Akhir
    Route::post('/pengajuan/{public_id}/laporan', [\App\Http\Controllers\Pengguna\LaporanAkhirController::class, 'store'])->name('pengajuan.laporan.store');

    // Pengisian Survei IKM / SKM
    Route::post('/pengajuan/{public_id}/skm', [\App\Http\Controllers\Pengguna\SkmController::class, 'store'])->name('pengajuan.skm.store');
});

// 3. Route Petugas (Operational Staff & Administrators)
Route::middleware(['auth', 'role:Petugas|Administrator'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Petugas\DashboardController::class, 'index'])->name('dashboard');
    
    // Verifikasi Pengajuan
    Route::get('/verifikasi', [\App\Http\Controllers\Petugas\VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{public_id}', [\App\Http\Controllers\Petugas\VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::post('/verifikasi/{public_id}', [\App\Http\Controllers\Petugas\VerifikasiController::class, 'verifikasi'])->name('verifikasi.process');

    // Review Laporan Akhir
    Route::get('/review-laporan', [\App\Http\Controllers\Petugas\ReviewLaporanController::class, 'index'])->name('review-laporan.index');
    Route::get('/review-laporan/{public_id}', [\App\Http\Controllers\Petugas\ReviewLaporanController::class, 'show'])->name('review-laporan.show');
    Route::post('/review-laporan/{public_id}', [\App\Http\Controllers\Petugas\ReviewLaporanController::class, 'review'])->name('review-laporan.process');

    // Kelola Bidang penempatan
    Route::resource('/bidang', \App\Http\Controllers\Petugas\BidangController::class);
});

// 4. Route Administrator (System controller)
Route::middleware(['auth', 'role:Administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    
    // User Directory Management
    Route::resource('/user', \App\Http\Controllers\Admin\UserController::class)->except(['show']);

    // SKM Questions CRUD Configuration
    Route::resource('/skm-pertanyaan', \App\Http\Controllers\Admin\SkmPertanyaanController::class)->except(['show']);

    // Annual Excel & CSV Statistics Export
    Route::get('/laporan/export-excel', [\App\Http\Controllers\Admin\LaporanStatistikController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-csv', [\App\Http\Controllers\Admin\LaporanStatistikController::class, 'exportCsv'])->name('laporan.csv');

    // Rekap SKM Kuartal
    Route::get('/rekap-skm', [\App\Http\Controllers\Admin\RekapSkmController::class, 'index'])->name('rekap-skm.index');
    Route::get('/rekap-skm/export-excel', [\App\Http\Controllers\Admin\RekapSkmController::class, 'exportExcel'])->name('rekap-skm.excel');
    Route::get('/rekap-skm/export-csv', [\App\Http\Controllers\Admin\RekapSkmController::class, 'exportCsv'])->name('rekap-skm.csv');

    // Riwayat Pengajuan Magang (Filter & Detail)
    Route::get('/riwayat-pengajuan', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'index'])->name('riwayat-pengajuan.index');
    Route::get('/riwayat-pengajuan/{public_id}', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'show'])->name('riwayat-pengajuan.show');
});

// 5. Shared Authenticated Profile & Private File Serving Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Secure private file serving route
    Route::get('/pengajuan/{public_id}/file/{type}', [\App\Http\Controllers\Pengguna\DetailPengajuanController::class, 'downloadFile'])->name('pengajuan.file');
});

// 6. Temporary token-protected deployment route for Hostinger Shared Hosting (No SSH)
Route::get('/deploy-migrations-and-links/{token}', function ($token) {
    if ($token !== 'brmp-biogen-deploy-token-2026') {
        abort(403, 'Akses ditolak.');
    }
    try {
        // Run database migrations
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

        // Run storage link
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $linkOutput = \Illuminate\Support\Facades\Artisan::output();

        return response()->json([
            'status' => 'success',
            'migration' => $migrateOutput,
            'storage_link' => $linkOutput,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
})->name('deploy.run');

require __DIR__.'/auth.php';
