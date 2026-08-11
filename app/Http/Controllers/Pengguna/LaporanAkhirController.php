<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanAkhirController extends Controller
{
    /**
     * Store the uploaded final report.
     */
    public function store(Request $request, string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if application is in active internship stage
        if ($pengajuan->status !== 'Sedang Magang') {
            return back()->with('error', 'Unggah laporan akhir hanya dapat dilakukan saat status sedang magang.');
        }

        // Validate file
        $request->validate([
            'file_laporan_akhir' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'file_laporan_akhir.required' => 'Berkas laporan akhir wajib diunggah.',
            'file_laporan_akhir.mimes' => 'Format file laporan akhir harus berupa PDF.',
            'file_laporan_akhir.max' => 'Ukuran file laporan akhir maksimal 2MB.',
        ]);

        $file = $request->file('file_laporan_akhir');
        if ($file->getClientOriginalExtension() !== 'pdf' || $file->getMimeType() !== 'application/pdf') {
            return back()->with('error', 'Unggahan gagal. Berkas laporan akhir harus berupa dokumen PDF asli.');
        }

        // Delete old report if exists
        if ($pengajuan->file_laporan_akhir) {
            Storage::disk('local')->delete($pengajuan->file_laporan_akhir);
        }

        // Store new report securely on local disk (private)
        $path = $file->store('laporan_akhir', 'local');

        // Update database columns
        $pengajuan->update([
            'file_laporan_akhir' => $path,
            'laporan_status' => 'Menunggu Review',
        ]);

        // Create in-app notification for Petugas pembimbing (if assigned) or all staff
        $targetUserId = $pengajuan->bidang->pembimbing_id;
        if ($targetUserId) {
            Notifikasi::create([
                'user_id' => $targetUserId,
                'judul' => 'Ulasan Laporan Akhir Baru',
                'pesan' => "Peserta magang {$pengajuan->user->name} ({$pengajuan->nomor_pengajuan}) telah mengunggah Laporan Akhir. Segera lakukan review.",
            ]);
        } else {
            // If no pembimbing assigned, notify all Petugas
            $petugasUsers = User::role('Petugas')->get();
            foreach ($petugasUsers as $petugas) {
                Notifikasi::create([
                    'user_id' => $petugas->id,
                    'judul' => 'Ulasan Laporan Akhir Baru',
                    'pesan' => "Peserta magang {$pengajuan->user->name} ({$pengajuan->nomor_pengajuan}) telah mengunggah Laporan Akhir.",
                ]);
            }
        }

        return back()->with('success', 'Laporan akhir berhasil diunggah dan sedang menunggu tinjauan petugas.');
    }
}
