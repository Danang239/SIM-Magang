<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewLaporanRequest;
use App\Models\Pengajuan;
use App\Models\Notifikasi;
use App\Services\PengajuanService;
use App\Mail\LaporanDitolakMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReviewLaporanController extends Controller
{
    public function __construct(
        protected PengajuanService $pengajuanService
    ) {}

    /**
     * Display a listing of applications with pending report reviews.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::where('laporan_status', 'Menunggu Review')
            ->with(['user', 'bidang']);

        // Search by applicant name or nomor_pengajuan
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $pengajuans = $query->orderBy('updated_at', 'asc')->paginate(10)->withQueryString();

        return view('petugas.review-laporan.index', compact('pengajuans'));
    }

    /**
     * Display the details of the report for review.
     */
    public function show(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('laporan_status', 'Menunggu Review')
            ->with(['user', 'bidang'])
            ->firstOrFail();

        return view('petugas.review-laporan.show', compact('pengajuan'));
    }

    /**
     * Process review decision (Terima/Tolak).
     */
    public function review(ReviewLaporanRequest $request, string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('laporan_status', 'Menunggu Review')
            ->firstOrFail();

        $action = $request->input('action');
        $catatan = $request->input('catatan');

        if ($action === 'terima') {
            $file = $request->file('file_surat_keterangan');
            if ($file->getClientOriginalExtension() !== 'pdf' || $file->getMimeType() !== 'application/pdf') {
                return back()->withErrors(['file_surat_keterangan' => 'File surat keterangan harus berupa dokumen PDF asli.'])->withInput();
            }

            // Delete old certificate if exists
            if ($pengajuan->file_surat_keterangan) {
                Storage::disk('local')->delete($pengajuan->file_surat_keterangan);
            }

            // Store new certificate on local disk (private)
            $path = $file->store('surat_keterangan', 'local');

            // Update report columns first
            $pengajuan->update([
                'laporan_status' => 'Diterima',
                'file_surat_keterangan' => $path,
            ]);

            // Transition main application status to Selesai via service (dispatches events, status log, email)
            $this->pengajuanService->ubahStatus(
                $pengajuan,
                'Selesai',
                'Laporan akhir disetujui. Program magang dinyatakan selesai secara formal.',
                auth()->id()
            );

            $msg = 'Laporan akhir diterima dan status magang berhasil diselesaikan.';
        } else {
            // Rejection: status remains Sedang Magang, only laporan_status changes
            $pengajuan->update([
                'laporan_status' => 'Ditolak',
            ]);

            // Save status log for audit trail (direct write since main status remains Sedang Magang)
            \App\Models\PengajuanStatusLog::create([
                'pengajuan_id' => $pengajuan->id,
                'status' => 'Sedang Magang',
                'catatan' => 'Laporan Akhir DITOLAK. Catatan revisi: ' . $catatan,
                'created_by' => auth()->id(),
            ]);

            // Send in-app notification to the user
            Notifikasi::create([
                'user_id' => $pengajuan->user_id,
                'judul' => 'Laporan Akhir Ditangguhkan',
                'pesan' => "Laporan akhir Anda ditolak/perlu revisi. Catatan: " . $catatan,
            ]);

            // Queue rejection email (processed by queue worker)
            Mail::to($pengajuan->user->email)->queue(new LaporanDitolakMail($pengajuan, $catatan));

            $msg = 'Laporan akhir ditolak dan catatan revisi telah dikirim ke peserta.';
        }

        return redirect()->route('petugas.review-laporan.index')->with('success', $msg);
    }
}
