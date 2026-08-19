<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangDetailController extends Controller
{
    /**
     * Display the detail page of a specific bidang.
     */
    public function show(Bidang $bidang)
    {
        $bidang->load('petugasList');

        $petugasWithQuota = $bidang->petugasList->map(function ($petugas) use ($bidang) {
            $kuota = $petugas->pivot->kuota ?? 5;
            $activeCount = \App\Models\Pengajuan::where('bidang_id', $bidang->id)
                ->where('pembimbing_id', $petugas->id)
                ->whereIn('status', ['Disetujui', 'Terjadwal', 'Sedang Magang'])
                ->count();

            $petugas->sisa_kuota = max(0, $kuota - $activeCount);
            $petugas->kuota_total = $kuota;

            return $petugas;
        });

        // Fallback jika belum ada petugasList di pivot
        if ($petugasWithQuota->isEmpty() && $bidang->pembimbing) {
            $p = $bidang->pembimbing;
            $activeCount = \App\Models\Pengajuan::where('bidang_id', $bidang->id)
                ->whereIn('status', ['Disetujui', 'Terjadwal', 'Sedang Magang'])
                ->count();
            $p->sisa_kuota = max(0, $bidang->kapasitas - $activeCount);
            $p->kuota_total = $bidang->kapasitas;
            $petugasWithQuota = collect([$p]);
        }

        $kapasitasTotal = $petugasWithQuota->sum('kuota_total') ?: $bidang->kapasitas;
        $sisaKuotaTotal = $petugasWithQuota->sum('sisa_kuota');

        return view('guest.bidang.show', compact('bidang', 'petugasWithQuota', 'kapasitasTotal', 'sisaKuotaTotal'));
    }
}
