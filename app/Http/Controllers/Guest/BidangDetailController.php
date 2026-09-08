<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class BidangDetailController extends Controller
{
    /**
     * Display the detail page of a specific bidang.
     */
    public function show(Bidang $bidang)
    {
        $bidang->load('pembimbings');

        $pembimbingWithQuota = $bidang->pembimbings->where('is_active', true)->map(function ($pembimbing) use ($bidang) {
            $kuota = $pembimbing->pivot->kuota ?? $pembimbing->kuota_default ?? 5;
            $activeCount = Pengajuan::where('bidang_id', $bidang->id)
                ->where('pembimbing_id', $pembimbing->id)
                ->whereIn('status', ['Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                ->count();

            $pembimbing->sisa_kuota = max(0, $kuota - $activeCount);
            $pembimbing->kuota_total = $kuota;

            return $pembimbing;
        });

        // Fallback jika belum ada relasi pivot, ambil semua pembimbing aktif
        if ($pembimbingWithQuota->isEmpty()) {
            $allActive = Pembimbing::where('is_active', true)->get()->map(function ($pembimbing) use ($bidang) {
                $kuota = $pembimbing->kuota_default ?? 5;
                $activeCount = Pengajuan::where('bidang_id', $bidang->id)
                    ->where('pembimbing_id', $pembimbing->id)
                    ->whereIn('status', ['Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                    ->count();

                $pembimbing->sisa_kuota = max(0, $kuota - $activeCount);
                $pembimbing->kuota_total = $kuota;

                return $pembimbing;
            });
            $pembimbingWithQuota = $allActive;
        }

        $kapasitasTotal = $pembimbingWithQuota->sum('kuota_total') ?: $bidang->kapasitas;
        $sisaKuotaTotal = $pembimbingWithQuota->sum('sisa_kuota');

        return view('guest.bidang.show', compact('bidang', 'pembimbingWithQuota', 'kapasitasTotal', 'sisaKuotaTotal'));
    }
}
