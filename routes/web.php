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

// Fallback route 'dashboard' used by Breeze auth controllers
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('Administrator')) {
        return redirect()->route('admin.dashboard');
    }
    if (session()->has('bidang_id')) {
        return redirect()->route('pengguna.career.step1', ['bidang_id' => session('bidang_id')]);
    }
    return redirect()->route('pengguna.dashboard');
})->middleware(['auth'])->name('dashboard');

// 2. Route Pengguna (Magang/PKL Applicants)
Route::middleware(['auth', 'role:Pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Pengguna\DashboardController::class, 'index'])->name('dashboard');

    // Career Form 2-step wizard
    Route::prefix('career')->name('career.')->group(function () {
        Route::get('/step1',   [\App\Http\Controllers\Pengguna\CareerController::class, 'step1'])->name('step1');
        Route::post('/step1',  [\App\Http\Controllers\Pengguna\CareerController::class, 'step1Store'])->name('step1.store');
        Route::get('/step2',   [\App\Http\Controllers\Pengguna\CareerController::class, 'step2'])->name('step2');
        Route::post('/step2',  [\App\Http\Controllers\Pengguna\CareerController::class, 'storeFinal'])
            ->middleware('throttle:3,1')
            ->name('store');
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

    // Pengisian Survei IKM / SKM
    Route::post('/pengajuan/{public_id}/skm', [\App\Http\Controllers\Pengguna\SkmController::class, 'store'])
        ->middleware('throttle:3,1')
        ->name('pengajuan.skm.store');
});

// 3. Route Administrator (System & Admission Controller)
Route::middleware(['auth', 'role:Administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Riwayat Pengajuan & Verifikasi Satu Pintu
    Route::get('/riwayat-pengajuan', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'index'])->name('riwayat-pengajuan.index');
    Route::get('/riwayat-pengajuan/{public_id}', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'show'])->name('riwayat-pengajuan.show');
    Route::post('/riwayat-pengajuan/{public_id}/verifikasi', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'verifikasi'])->name('riwayat-pengajuan.verifikasi');
    Route::get('/riwayat-pengajuan/{public_id}/export-pdf', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'exportPdf'])->name('riwayat-pengajuan.export-pdf');
    Route::get('/riwayat-pengajuan/{public_id}/export-word', [\App\Http\Controllers\Admin\RiwayatPengajuanController::class, 'exportWord'])->name('riwayat-pengajuan.export-word');

    // Master Data Pembimbing
    Route::resource('/pembimbing', \App\Http\Controllers\Admin\PembimbingController::class)->except(['show']);

    // Kelola Bidang Penempatan
    Route::resource('/bidang', \App\Http\Controllers\Admin\BidangController::class)->except(['show']);

    // User Directory Management (View, Edit, Update, Delete)
    Route::resource('/user', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'edit', 'update', 'destroy']);

    // SKM Questions CRUD Configuration
    Route::resource('/skm-pertanyaan', \App\Http\Controllers\Admin\SkmPertanyaanController::class)->except(['show']);

    // Annual Excel & CSV Statistics Export
    Route::get('/laporan/export-excel', [\App\Http\Controllers\Admin\LaporanStatistikController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-csv', [\App\Http\Controllers\Admin\LaporanStatistikController::class, 'exportCsv'])->name('laporan.csv');

    // Rekap SKM Kuartal
    Route::get('/rekap-skm', [\App\Http\Controllers\Admin\RekapSkmController::class, 'index'])->name('rekap-skm.index');
    Route::get('/rekap-skm/export-excel', [\App\Http\Controllers\Admin\RekapSkmController::class, 'exportExcel'])->name('rekap-skm.excel');
    Route::get('/rekap-skm/export-csv', [\App\Http\Controllers\Admin\RekapSkmController::class, 'exportCsv'])->name('rekap-skm.csv');
});

// 4. Shared Authenticated Profile & Private File Serving Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Secure private file serving route
    Route::get('/pengajuan/{public_id}/file/{type}', [\App\Http\Controllers\Pengguna\DetailPengajuanController::class, 'downloadFile'])->name('pengajuan.file');
});

// 5. Deployment Helper Route
Route::get('/deploy-migrations-and-links/{token}', function ($token) {
    if ($token !== env('DEPLOY_TOKEN')) {
        abort(403, 'Akses ditolak.');
    }
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

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
