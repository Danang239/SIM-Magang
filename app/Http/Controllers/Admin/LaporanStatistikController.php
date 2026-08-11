<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanMagangExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanStatistikController extends Controller
{
    /**
     * Export annual statistics as Excel file.
     */
    public function exportExcel(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        return Excel::download(
            new LaporanMagangExport($year),
            "Laporan_Rekapitulasi_Tahunan_Magang_{$year}.xlsx"
        );
    }

    /**
     * Export annual statistics as CSV file.
     */
    public function exportCsv(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        return Excel::download(
            new LaporanMagangExport($year),
            "Laporan_Rekapitulasi_Tahunan_Magang_{$year}.csv",
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
