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
                ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                ->count();

            $pembimbing->sisa_kuota = max(0, $kuota - $activeCount);
            $pembimbing->kuota_total = $kuota;

            // Hitung tanggal ketersediaan terdekat jika kuota penuh
            if ($pembimbing->sisa_kuota === 0) {
                $earliestEnd = Pengajuan::where('bidang_id', $bidang->id)
                    ->where('pembimbing_id', $pembimbing->id)
                    ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                    ->where('tanggal_selesai_rencana', '>=', \Carbon\Carbon::today())
                    ->orderBy('tanggal_selesai_rencana', 'asc')
                    ->value('tanggal_selesai_rencana');

                if ($earliestEnd) {
                    $nextDate = \Carbon\Carbon::parse($earliestEnd)->addDay();
                    $minLead = \Carbon\Carbon::today()->addDays(14);
                    $pembimbing->tanggal_tersedia_terdekat = $nextDate->lt($minLead) ? $minLead : $nextDate;
                } else {
                    $pembimbing->tanggal_tersedia_terdekat = \Carbon\Carbon::today()->addDays(14);
                }

                $activeOnNextDate = Pengajuan::where('bidang_id', $bidang->id)
                    ->where('pembimbing_id', $pembimbing->id)
                    ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                    ->where('tanggal_mulai', '<=', $pembimbing->tanggal_tersedia_terdekat)
                    ->where('tanggal_selesai_rencana', '>=', $pembimbing->tanggal_tersedia_terdekat)
                    ->count();

                $pembimbing->slot_tersedia_terdekat = max(1, $kuota - $activeOnNextDate);
            } else {
                $pembimbing->tanggal_tersedia_terdekat = \Carbon\Carbon::today()->addDays(14);
                $pembimbing->slot_tersedia_terdekat = $pembimbing->sisa_kuota;
            }

            $maxHorizon = \Carbon\Carbon::today()->addMonths(4)->endOfMonth();
            $pembimbing->is_di_luar_rentang = $pembimbing->sisa_kuota === 0 && $pembimbing->tanggal_tersedia_terdekat->gt($maxHorizon);

            return $pembimbing;
        });

        // Fallback jika belum ada relasi pivot, ambil semua pembimbing aktif
        if ($pembimbingWithQuota->isEmpty()) {
            $allActive = Pembimbing::where('is_active', true)->get()->map(function ($pembimbing) use ($bidang) {
                $kuota = $pembimbing->kuota_default ?? 5;
                $activeCount = Pengajuan::where('bidang_id', $bidang->id)
                    ->where('pembimbing_id', $pembimbing->id)
                    ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                    ->count();

                $pembimbing->sisa_kuota = max(0, $kuota - $activeCount);
                $pembimbing->kuota_total = $kuota;

                if ($pembimbing->sisa_kuota === 0) {
                    $earliestEnd = Pengajuan::where('bidang_id', $bidang->id)
                        ->where('pembimbing_id', $pembimbing->id)
                        ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                        ->where('tanggal_selesai_rencana', '>=', \Carbon\Carbon::today())
                        ->orderBy('tanggal_selesai_rencana', 'asc')
                        ->value('tanggal_selesai_rencana');

                    if ($earliestEnd) {
                        $nextDate = \Carbon\Carbon::parse($earliestEnd)->addDay();
                        $minLead = \Carbon\Carbon::today()->addDays(14);
                        $pembimbing->tanggal_tersedia_terdekat = $nextDate->lt($minLead) ? $minLead : $nextDate;
                    } else {
                        $pembimbing->tanggal_tersedia_terdekat = \Carbon\Carbon::today()->addDays(14);
                    }

                    $activeOnNextDate = Pengajuan::where('bidang_id', $bidang->id)
                        ->where('pembimbing_id', $pembimbing->id)
                        ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                        ->where('tanggal_mulai', '<=', $pembimbing->tanggal_tersedia_terdekat)
                        ->where('tanggal_selesai_rencana', '>=', $pembimbing->tanggal_tersedia_terdekat)
                        ->count();

                    $pembimbing->slot_tersedia_terdekat = max(1, $kuota - $activeOnNextDate);
                } else {
                    $pembimbing->tanggal_tersedia_terdekat = \Carbon\Carbon::today()->addDays(14);
                    $pembimbing->slot_tersedia_terdekat = $pembimbing->sisa_kuota;
                }

                $maxHorizon = \Carbon\Carbon::today()->addMonths(4)->endOfMonth();
                $pembimbing->is_di_luar_rentang = $pembimbing->sisa_kuota === 0 && $pembimbing->tanggal_tersedia_terdekat->gt($maxHorizon);

                return $pembimbing;
            });
            $pembimbingWithQuota = $allActive;
        }

        $kapasitasTotal = $pembimbingWithQuota->sum('kuota_total') ?: $bidang->kapasitas;
        $sisaKuotaTotal = $pembimbingWithQuota->sum('sisa_kuota');

        $activePengajuan = null;
        if (auth()->check() && auth()->user()->hasRole('Pengguna')) {
            $activePengajuan = Pengajuan::where('user_id', auth()->id())
                ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'])
                ->first();
        }

        return view('guest.bidang.show', compact('bidang', 'pembimbingWithQuota', 'kapasitasTotal', 'sisaKuotaTotal', 'activePengajuan'));
    }
}
