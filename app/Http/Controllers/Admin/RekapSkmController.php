<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RekapSkmExport;
use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\SkmJawaban;
use App\Models\SkmPertanyaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapSkmController extends Controller
{
    /**
     * Display the quarterly summary of SKM rating results.
     */
    public function index(Request $request)
    {
        $year = (int) $request->input('year', Carbon::now()->year);
        $quarter = (int) $request->input('quarter', 1);

        $startMonth = (($quarter - 1) * 3) + 1;
        $startDate = Carbon::create($year, $startMonth, 1)->startOfDay();
        $endDate = $startDate->copy()->addMonths(3)->subDay()->endOfDay();

        $pertanyaans = SkmPertanyaan::where('is_active', true)->orderBy('urutan', 'asc')->get();

        $totalResponden = Pengajuan::whereHas('skmJawabans', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->count();

        $rekapData = [];
        foreach ($pertanyaans as $p) {
            $average = SkmJawaban::where('skm_pertanyaan_id', $p->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->avg('rating');

            $rekapData[] = [
                'id' => $p->id,
                'teks' => $p->teks_pertanyaan,
                'average' => $average ? number_format($average, 2) : '0.00',
            ];
        }

        return view('admin.rekap-skm.index', compact('year', 'quarter', 'rekapData', 'totalResponden'));
    }

    /**
     * Export quarterly SKM details to Excel.
     */
    public function exportExcel(Request $request)
    {
        $year = (int) $request->input('year', Carbon::now()->year);
        $quarter = (int) $request->input('quarter', 1);

        return Excel::download(
            new RekapSkmExport($year, $quarter),
            "Rekap_SKM_Kuartal_{$quarter}_{$year}.xlsx"
        );
    }

    /**
     * Export quarterly SKM details to CSV.
     */
    public function exportCsv(Request $request)
    {
        $year = (int) $request->input('year', Carbon::now()->year);
        $quarter = (int) $request->input('quarter', 1);

        return Excel::download(
            new RekapSkmExport($year, $quarter),
            "Rekap_SKM_Kuartal_{$quarter}_{$year}.csv",
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
