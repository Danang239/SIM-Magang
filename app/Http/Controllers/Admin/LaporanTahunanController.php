<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\SkmJawaban;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanTahunanController extends Controller
{
    /**
     * Export the annual internship report as PDF.
     */
    public function export(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        // 1. Total pendaftar
        $totalSubmissions = Pengajuan::whereYear('created_at', $year)->count();

        // 2. Jumlah pendaftar per status
        $statusCounts = Pengajuan::whereYear('created_at', $year)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $statuses = [
            'Menunggu Verifikasi',
            'Disetujui',
            'Ditolak',
            'Terjadwal',
            'Sedang Magang',
            'Selesai',
            'Dibatalkan'
        ];

        $statusStats = [];
        foreach ($statuses as $status) {
            $statusStats[$status] = $statusCounts[$status] ?? 0;
        }

        // 3. Distribusi pendaftar per bidang
        $bidangStats = Bidang::withCount(['pengajuans' => function ($q) use ($year) {
            $q->whereYear('created_at', $year);
        }])
        ->orderBy('pengajuans_count', 'desc')
        ->get();

        // 4. Rata-rata SKM untuk pengajuan tahun tersebut
        $skmAverage = SkmJawaban::whereHas('pengajuan', function ($q) use ($year) {
            $q->whereYear('created_at', $year);
        })
        ->avg('rating');

        $skmAverage = $skmAverage ? number_format($skmAverage, 2) : 'Belum Ada';

        // Load PDF view
        $pdf = Pdf::loadView('admin.laporan-tahunan.pdf', [
            'year' => $year,
            'totalSubmissions' => $totalSubmissions,
            'statusStats' => $statusStats,
            'bidangStats' => $bidangStats,
            'skmAverage' => $skmAverage,
            'generatedAt' => Carbon::now()->translatedFormat('d F Y H:i'),
        ]);

        return $pdf->download("Laporan_Rekapitulasi_Tahunan_Magang_{$year}.pdf");
    }
}
