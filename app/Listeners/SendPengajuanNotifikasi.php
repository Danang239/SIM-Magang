<?php

namespace App\Listeners;

use App\Events\PengajuanStatusChanged;
use App\Models\Notifikasi;

class SendPengajuanNotifikasi
{
    /**
     * Handle the event.
     */
    public function handle(PengajuanStatusChanged $event): void
    {
        $pengajuan = $event->pengajuan;
        $nomor = $pengajuan->nomor_pengajuan;

        $pesan = match ($pengajuan->status) {
            'Disetujui' => "Pengajuan magang Anda dengan nomor {$nomor} telah DISETUJUI oleh petugas. Persiapan kedatangan sedang dijadwalkan.",
            'Ditolak' => "Pengajuan magang Anda dengan nomor {$nomor} DITOLAK oleh petugas. Catatan: " . ($event->catatan ?? '-'),
            'Terjadwal' => "Pengajuan magang Anda dengan nomor {$nomor} berstatus Terjadwal. Silakan persiapkan berkas fisik pada hari pertama.",
            'Sedang Magang' => "Program magang Anda dengan nomor {$nomor} sudah aktif (Sedang Magang). Selamat melaksanakan magang di BRMP Biogen!",
            'Selesai' => "Program magang Anda dengan nomor {$nomor} telah dinyatakan Selesai. Anda dapat mengunduh Surat Keterangan Selesai Magang sekarang.",
            'Dibatalkan' => "Pengajuan magang Anda dengan nomor {$nomor} telah berhasil dibatalkan.",
            default => "Status pengajuan magang Anda dengan nomor {$nomor} telah diperbarui menjadi: {$pengajuan->status}."
        };

        Notifikasi::create([
            'user_id' => $pengajuan->user_id,
            'judul' => 'Pembaruan Status Pengajuan',
            'pesan' => $pesan,
        ]);
    }
}
