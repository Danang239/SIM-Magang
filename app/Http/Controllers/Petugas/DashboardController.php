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

        // Retrieve real statistics for registration-to-acceptance workflow
        $stats = [
            'total' => Pengajuan::count(),
            'menunggu' => Pengajuan::where('status', 'Menunggu Verifikasi')->count(),
            'disetujui_bulan_ini' => Pengajuan::whereIn('status', ['Disetujui', 'Terjadwal'])
                ->where('updated_at', '>=', $startOfMonth)
                ->count(),
            'aktif' => Pengajuan::whereIn('status', ['Disetujui', 'Terjadwal', 'Aktif'])
                ->where('tanggal_selesai_rencana', '>=', $today)
                ->count(),
            'selesai' => Pengajuan::where('status', 'Selesai')
                ->orWhere(function($query) use ($today) {
                    $query->whereIn('status', ['Disetujui', 'Terjadwal', 'Aktif'])
                          ->where('tanggal_selesai_rencana', '<', $today);
                })
                ->count(),
        ];

        // Retrieve oldest 5 pending applications for action queue
        $antrean = Pengajuan::where('status', 'Menunggu Verifikasi')
            ->with(['user', 'bidang'])
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // Retrieve recent approved applicants
        $terjadwalList = Pengajuan::whereIn('status', ['Disetujui', 'Terjadwal'])
            ->where('tanggal_selesai_rencana', '>=', $today)
            ->with(['user', 'bidang'])
            ->orderBy('tanggal_mulai', 'asc')
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact('stats', 'antrean', 'terjadwalList'));
    }
}
