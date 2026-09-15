<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Services\PengajuanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailPengajuanController extends Controller
{
    public function __construct(
        protected PengajuanService $pengajuanService
    ) {}

    /**
     * Display details of a specific application.
     */
    public function show(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('user_id', auth()->id())
            ->with(['bidang', 'pembimbing', 'statusLogs', 'statusLogs.user'])
            ->firstOrFail();

        // Sort status logs descending or ascending as appropriate (timeline shows ascending sequence)
        $statusLogs = $pengajuan->statusLogs()->orderBy('created_at', 'asc')->get();

        $activeSkmQuestions = [];
        if ($pengajuan->status === 'Selesai' && !$pengajuan->skmJawabans()->exists()) {
            $activeSkmQuestions = \App\Models\SkmPertanyaan::where('is_active', true)->orderBy('urutan', 'asc')->get();
        }

        return view('pengguna.detail.show', compact('pengajuan', 'statusLogs', 'activeSkmQuestions'));
    }

    /**
     * Securely download or display files from the private storage.
     */
    public function downloadFile(string $publicId, string $type)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)->firstOrFail();

        // Security check: Only the applicant user OR staff/admin can access
        $user = auth()->user();
        if ($pengajuan->user_id !== $user->id && !$user->hasRole('Administrator')) {
            abort(403, 'Anda tidak diizinkan mengakses file ini.');
        }

        // Pengguna pemilik hanya bisa unduh surat_balasan jika SKM sudah diisi
        if ($type === 'surat_balasan' && $pengajuan->user_id === $user->id) {
            $skmQuestionsCount = \App\Models\SkmPertanyaan::where('is_active', true)->count();
            $skmAnsweredCount = $pengajuan->skmJawabans()->count();
            $skmCompleted = ($skmAnsweredCount >= $skmQuestionsCount && $skmQuestionsCount > 0);

            if (!$skmCompleted) {
                abort(403, 'Anda wajib melengkapi kuesioner SKM terlebih dahulu sebelum dapat mengunduh surat balasan.');
            }
        }

        // Get the requested file path
        $path = match ($type) {
            'foto_diri' => $pengajuan->foto_diri,
            'surat_pengantar' => $pengajuan->file_surat_pengantar,
            'surat_balasan' => $pengajuan->file_surat_balasan,
            default => null,
        };

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('local')->response($path);
    }

    /**
     * Cancel an application.
     */
    public function cancel(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if status is cancellable
        $allowedStatuses = ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal'];
        if (!in_array($pengajuan->status, $allowedStatuses)) {
            return back()->with('error', 'Pengajuan ini tidak dapat dibatalkan karena sudah diproses lebih lanjut.');
        }

        // Update status using the Service entry point
        $this->pengajuanService->ubahStatus(
            $pengajuan,
            'Dibatalkan',
            'Dibatalkan secara mandiri oleh pemohon.',
            auth()->id()
        );

        // Generate in-app notification
        \App\Models\Notifikasi::create([
            'user_id' => auth()->id(),
            'judul' => 'Pengajuan Dibatalkan',
            'pesan' => "Pengajuan magang Anda dengan nomor {$pengajuan->nomor_pengajuan} telah berhasil dibatalkan.",
        ]);

        return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)
            ->with('success', 'Pengajuan Anda berhasil dibatalkan.');
    }
}
