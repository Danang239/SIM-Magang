<?php

namespace App\Services;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\DB;

class PengajuanService
{
    /**
     * Generate nomor pengajuan unik dengan format PKL-{TAHUN}-{URUT}.
     * Menggunakan DB lock untuk mencegah race condition (nomor duplikat).
     * Harus dipanggil di dalam DB::transaction().
     *
     * @return string  Contoh: PKL-2026-0001
     */
    public function generateNomorPengajuan(): string
    {
        $tahun = now()->year;
        $prefix = sprintf('PKL-%d-', $tahun);

        // Cari nomor pengajuan terakhir untuk tahun ini berdasarkan angka urutan tertinggi
        $last = Pengajuan::where('nomor_pengajuan', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByRaw('CAST(SUBSTRING(nomor_pengajuan, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
            ->value('nomor_pengajuan');

        if ($last) {
            $lastNumber = (int) substr($last, strlen($prefix));
            $urut = $lastNumber + 1;
        } else {
            $urut = 1;
        }

        // Loop safety untuk memastikan nomor benar-benar belum terpakai di database
        do {
            $nomor = sprintf('%s%04d', $prefix, $urut);
            $exists = Pengajuan::where('nomor_pengajuan', $nomor)->exists();
            if ($exists) {
                $urut++;
            }
        } while ($exists);

        return $nomor;
    }

    /**
     * Ubah status pengajuan melalui satu titik masuk yang tunggal.
     * Akan diimplementasikan penuh di Milestone 5 (termasuk Event & Listener).
     * Saat ini berisi logika minimal untuk keperluan milestone sebelumnya.
     *
     * @param  Pengajuan    $pengajuan
     * @param  string       $statusBaru
     * @param  string|null  $catatan
     * @param  int|null     $createdBy  User ID yang melakukan perubahan (null = otomatis)
     * @return Pengajuan
     */
    public function ubahStatus(Pengajuan $pengajuan, string $statusBaru, ?string $catatan = null, ?int $createdBy = null): Pengajuan
    {
        $pengajuan->update(['status' => $statusBaru, 'catatan_petugas' => $catatan]);

        // Trigger the status changed event (logs status, sends in-app notifications, and queues emails)
        event(new \App\Events\PengajuanStatusChanged($pengajuan, $catatan, $createdBy));

        return $pengajuan->fresh();
    }
}
