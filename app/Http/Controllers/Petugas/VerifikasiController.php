<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiRequest;
use App\Models\Pengajuan;
use App\Services\PengajuanService;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function __construct(
        protected PengajuanService $pengajuanService
    ) {}

    /**
     * Display a listing of applications waiting for verification.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::where('status', 'Menunggu Verifikasi')
            ->with(['user', 'bidang', 'pembimbing', 'bidang.petugasList']);

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

        $pengajuans = $query->orderBy('created_at', 'asc')->paginate(10)->withQueryString();

        return view('petugas.verifikasi.index', compact('pengajuans'));
    }

    /**
     * Display the details of the pending application.
     */
    public function show(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('status', 'Menunggu Verifikasi')
            ->with(['user', 'bidang', 'pembimbing', 'bidang.pembimbing', 'bidang.petugasList'])
            ->firstOrFail();

        return view('petugas.verifikasi.show', compact('pengajuan'));
    }

    /**
     * Process verification decision (Setujui/Tolak).
     */
    public function verifikasi(VerifikasiRequest $request, string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('status', 'Menunggu Verifikasi')
            ->firstOrFail();

        $action = $request->input('action');
        $catatan = $request->input('catatan');

        if ($action === 'setujui') {
            if ($request->hasFile('file_surat_balasan')) {
                $file = $request->file('file_surat_balasan');
                $allowedMimes = ['application/pdf'];
                $allowedExtensions = ['pdf'];
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, $allowedExtensions) || !in_array($file->getMimeType(), $allowedMimes)) {
                    return back()->withErrors(['file_surat_balasan' => 'Tipe file tidak diizinkan berdasarkan konten file. Harus PDF.'])->withInput();
                }
                
                $filePath = $file->store('surat-balasan', 'local');
                $pengajuan->file_surat_balasan = $filePath;
                $pengajuan->save();
            }

            $this->pengajuanService->ubahStatus(
                $pengajuan,
                'Disetujui',
                'Pengajuan disetujui oleh verifikator.',
                auth()->id()
            );
            $msg = 'Pengajuan berhasil disetujui.';
        } else {
            $this->pengajuanService->ubahStatus(
                $pengajuan,
                'Ditolak',
                $catatan,
                auth()->id()
            );
            $msg = 'Pengajuan berhasil ditolak.';
        }

        return redirect()->route('petugas.verifikasi.index')->with('success', $msg);
    }
}
