<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the Petugas dashboard with real-time stats and queue.
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Retrieve real statistics
        $stats = [
            'total' => Pengajuan::count(),
            'menunggu' => Pengajuan::where('status', 'Menunggu Verifikasi')->count(),
            'disetujui_bulan_ini' => Pengajuan::where('status', 'Disetujui')
                ->where('updated_at', '>=', $startOfMonth)
                ->count(),
            'laporan_review' => Pengajuan::where('laporan_status', 'Menunggu Review')->count(),
            'laporan_telat' => Pengajuan::where('status', 'Sedang Magang')
                ->where('tanggal_selesai_rencana', '<', $today)
                ->count(),
        ];

        // Retrieve oldest 5 pending applications for action queue
        $antrean = Pengajuan::where('status', 'Menunggu Verifikasi')
            ->with(['user', 'bidang'])
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // Retrieve list of overdue active participants
        $laporanTelatList = Pengajuan::where('status', 'Sedang Magang')
            ->where('tanggal_selesai_rencana', '<', $today)
            ->with(['user', 'bidang'])
            ->orderBy('tanggal_selesai_rencana', 'asc')
            ->get();

        return view('petugas.dashboard', compact('stats', 'antrean', 'laporanTelatList'));
    }
}
