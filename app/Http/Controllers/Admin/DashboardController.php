<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\SkmJawaban;
use App\Models\SkmPertanyaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the Admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_pengajuans' => Pengajuan::count(),
            'skm_average' => number_format(SkmJawaban::avg('rating') ?? 0, 2),
        ];

        // Bidang distribution data for Chart
        $bidangData = Bidang::withCount('pengajuans')->get()->map(function($bidang) {
            return [
                'nama' => $bidang->nama_bidang,
                'count' => $bidang->pengajuans_count,
            ];
        });

        // Monthly applications chart data
        $monthlyData = Pengajuan::select(
            DB::raw('count(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->take(12)
        ->get();

        // Query SKM Questions and rating response distributions for Pie Charts
        $skmQuestions = SkmPertanyaan::where('is_active', true)
            ->with(['skmJawabans'])
            ->orderBy('urutan', 'asc')
            ->get()
            ->map(function ($q) {
                $ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                foreach ($q->skmJawabans as $ans) {
                    if (isset($ratings[$ans->rating])) {
                        $ratings[$ans->rating]++;
                    }
                }
                return [
                    'id' => $q->id,
                    'teks' => $q->teks_pertanyaan,
                    'average' => number_format($q->skmJawabans->avg('rating') ?? 0, 2),
                    'total_responses' => $q->skmJawabans->count(),
                    'ratings' => array_values($ratings), // counts for [1, 2, 3, 4]
                ];
            });

        return view('admin.dashboard', compact('stats', 'bidangData', 'monthlyData', 'skmQuestions'));
    }
}
