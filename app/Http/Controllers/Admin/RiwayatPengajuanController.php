<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiRequest;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Services\PengajuanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatPengajuanController extends Controller
{
    public function __construct(
        protected PengajuanService $pengajuanService
    ) {}

    /**
     * Display a listing of all applications with filters.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::with(['user', 'bidang', 'pembimbing']);

        // Filter Bidang
        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->input('bidang_id'));
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter Tanggal Pengajuan (Dari)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->input('tanggal_dari'));
        }

        // Filter Tanggal Pengajuan (Sampai)
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->input('tanggal_sampai'));
        }

        // Search Keyword
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $bidangs = Bidang::orderBy('nama_bidang', 'asc')->get();

        return view('admin.riwayat-pengajuan.index', compact('pengajuans', 'bidangs'));
    }

    /**
     * Display details of a specific application and allow verification.
     */
    public function show(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->with(['user', 'bidang', 'pembimbing', 'statusLogs', 'statusLogs.user'])
            ->firstOrFail();

        $statusLogs = $pengajuan->statusLogs()->orderBy('created_at', 'asc')->get();
        $pembimbings = Pembimbing::where('is_active', true)->orderBy('nama', 'asc')->get();

        return view('admin.riwayat-pengajuan.show', compact('pengajuan', 'statusLogs', 'pembimbings'));
    }

    /**
     * Process verification decision (Setujui / Tolak) by Admin.
     */
    public function verifikasi(VerifikasiRequest $request, string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)->firstOrFail();

        $action = $request->input('action');
        $catatan = $request->input('catatan');

        if ($request->filled('pembimbing_id')) {
            $pengajuan->pembimbing_id = $request->input('pembimbing_id');
            $pengajuan->save();
        }

        if ($action === 'setujui') {
            if ($request->hasFile('file_surat_balasan')) {
                $file = $request->file('file_surat_balasan');
                $allowedMimes = ['application/pdf'];
                $allowedExtensions = ['pdf'];
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, $allowedExtensions) || !in_array($file->getMimeType(), $allowedMimes)) {
                    return back()->withErrors(['file_surat_balasan' => 'Tipe file tidak diizinkan. Harus file PDF.'])->withInput();
                }
                
                $filePath = $file->store('surat-balasan', 'local');
                $pengajuan->file_surat_balasan = $filePath;
                $pengajuan->save();
            }

            $this->pengajuanService->ubahStatus(
                $pengajuan,
                'Disetujui',
                'Pengajuan disetujui oleh Administrator.',
                auth()->id()
            );
            $msg = 'Pengajuan berhasil disetujui dan surat balasan telah diunggah.';
        } else {
            $this->pengajuanService->ubahStatus(
                $pengajuan,
                'Ditolak',
                $catatan,
                auth()->id()
            );
            $msg = 'Pengajuan berhasil ditolak.';
        }

        return redirect()->route('admin.riwayat-pengajuan.show', $pengajuan->public_id)
            ->with('success', $msg);
    }

    /**
     * Export Form-1 PT application data to clean official PDF.
     */
    public function exportPdf(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->with(['user', 'bidang', 'pembimbing'])
            ->firstOrFail();

        $logoBase64 = '';
        $logoPath = public_path('logo-brmp.png');
        if (file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        $fotoBase64 = '';
        if ($pengajuan->foto_diri && Storage::disk('local')->exists($pengajuan->foto_diri)) {
            $fotoPath = Storage::disk('local')->path($pengajuan->foto_diri);
            $fotoType = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoData = file_get_contents($fotoPath);
            $fotoBase64 = 'data:image/' . $fotoType . ';base64,' . base64_encode($fotoData);
        }

        $ttdBase64 = $pengajuan->tanda_tangan_digital;

        $pdf = Pdf::loadView('admin.riwayat-pengajuan.export-pdf', compact('pengajuan', 'logoBase64', 'fotoBase64', 'ttdBase64'))
            ->setPaper('a4', 'portrait')
            ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        $fileName = 'Form-1_Form-2_PKL_' . str_replace(['/', '\\', ' '], '_', $pengajuan->nomor_pengajuan) . '_' . str_replace(' ', '_', $pengajuan->user->name) . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Export Form-1 & Form-2 application data to clean Word document (.doc).
     */
    public function exportWord(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->with(['user', 'bidang', 'pembimbing'])
            ->firstOrFail();

        $logoBase64 = '';
        $logoPath = public_path('logo-brmp.png');
        if (file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        $fotoBase64 = '';
        if ($pengajuan->foto_diri && Storage::disk('local')->exists($pengajuan->foto_diri)) {
            $fotoPath = Storage::disk('local')->path($pengajuan->foto_diri);
            $fotoType = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoData = file_get_contents($fotoPath);
            $fotoBase64 = 'data:image/' . $fotoType . ';base64,' . base64_encode($fotoData);
        }

        $ttdBase64 = $pengajuan->tanda_tangan_digital;

        $viewContent = view('admin.riwayat-pengajuan.export-word', compact('pengajuan', 'logoBase64', 'fotoBase64', 'ttdBase64'))->render();

        $fileName = 'Form-1_Form-2_PKL_' . str_replace(['/', '\\', ' '], '_', $pengajuan->nomor_pengajuan) . '_' . str_replace(' ', '_', $pengajuan->user->name) . '.doc';

        return response($viewContent, 200, [
            'Content-Type' => 'application/msword; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }
}
