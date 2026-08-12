<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerStepBidangRequest;
use App\Http\Requests\CareerStepFinalRequest;
use App\Http\Requests\CareerStepTanggalRequest;
use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Models\SkmJawaban;
use App\Services\KuotaService;
use App\Services\PengajuanService;
use App\Services\SkmService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    public function __construct(
        protected KuotaService $kuotaService,
        protected PengajuanService $pengajuanService,
    ) {}

    // ─── STEP 1: Pilih Jenjang ─────────────────────────────────────────────
    public function step1()
    {
        // Bersihkan session career lama jika ada
        session()->forget(['career_step1', 'career_step2', 'career_step3', 'career_step4']);
        return view('pengguna.career.step1');
    }

    public function step1Store(Request $request)
    {
        $request->validate([
            'jenjang' => ['required', 'in:Siswa,Mahasiswa'],
        ]);

        session(['career_step1' => ['jenjang' => $request->jenjang]]);

        return redirect()->route('pengguna.career.step2');
    }

    // ─── STEP 2: Pilih Kategori Bidang (NEW) ──────────────────────────────────
    public function step2()
    {
        $step1 = session('career_step1');
        if (!$step1) {
            return redirect()->route('pengguna.career.step1')->with('error', 'Silakan mulai dari Step 1.');
        }

        $jenjang = $step1['jenjang'];
        return view('pengguna.career.step2', compact('jenjang'));
    }

    public function step2Store(Request $request)
    {
        $request->validate([
            'kategori' => ['required', 'in:Pertanian,Non Pertanian'],
        ]);

        session(['career_step2' => ['kategori' => $request->kategori]]);

        return redirect()->route('pengguna.career.step3');
    }

    // ─── STEP 3: Pilih Bidang, Durasi, Keahlian (OLD STEP 2) ──────────────────
    public function step3()
    {
        $step1 = session('career_step1');
        $step2 = session('career_step2');
        if (!$step1 || !$step2) {
            return redirect()->route('pengguna.career.step1')->with('error', 'Silakan lengkapi langkah sebelumnya.');
        }

        $jenjang = $step1['jenjang'];
        $kategori = $step2['kategori'];

        $bidangs = Bidang::where('is_active', true)
            ->where('jenjang', $jenjang)
            ->where('kategori', $kategori)
            ->with('pembimbing')
            ->get()
            ->map(function ($bidang) {
                // Hitung slot terisi untuk tanggal sekarang (indikator awal)
                $terisi = $this->kuotaService->hitungSlotTerisi($bidang->id, now()->addDay()->toDateString(), 2);
                $bidang->slot_sisa = max(0, $bidang->kapasitas - $terisi);
                $bidang->full = $terisi >= $bidang->kapasitas;
                return $bidang;
            });

        return view('pengguna.career.step3', compact('jenjang', 'kategori', 'bidangs'));
    }

    public function step3Store(CareerStepBidangRequest $request)
    {
        $validated = $request->validated();

        session(['career_step3' => [
            'jenjang' => $validated['jenjang'],
            'bidang_id' => $validated['bidang_id'],
            'durasi_bulan' => $validated['durasi_bulan'],
            'keahlian' => $validated['keahlian'],
        ]]);

        return redirect()->route('pengguna.career.step4');
    }

    // ─── STEP 4: Pilih Tanggal (OLD STEP 3) ──────────────────────────────────
    public function step4()
    {
        $step3 = session('career_step3');
        if (!$step3) {
            return redirect()->route('pengguna.career.step3')->with('error', 'Silakan lengkapi Step 3 terlebih dahulu.');
        }

        $bidang = Bidang::findOrFail($step3['bidang_id']);
        $durasiBulan = (int) $step3['durasi_bulan'];

        // Generate kalender 3 bulan ke depan
        $kalender = $this->kuotaService->getKalenderTersedia($bidang, $durasiBulan, 3);

        return view('pengguna.career.step4', compact('bidang', 'durasiBulan', 'kalender', 'step3'));
    }

    public function step4Store(CareerStepTanggalRequest $request)
    {
        $validated = $request->validated();
        $step3 = session('career_step3');

        $tanggalMulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggalSelesai = $tanggalMulai->copy()->addMonths((int) $step3['durasi_bulan'])->subDay();

        session(['career_step4' => [
            'tanggal_mulai' => $tanggalMulai->toDateString(),
            'tanggal_selesai_rencana' => $tanggalSelesai->toDateString(),
        ]]);

        return redirect()->route('pengguna.career.step5');
    }

    // ─── STEP 5: Upload Surat Pengantar (OLD STEP 4) ────────────────────
    public function step5()
    {
        $step3 = session('career_step3');
        $step4 = session('career_step4');

        if (!$step3 || !$step4) {
            return redirect()->route('pengguna.career.step4')->with('error', 'Silakan lengkapi Step 4 terlebih dahulu.');
        }

        $bidang = Bidang::with('pembimbing')->findOrFail($step3['bidang_id']);

        return view('pengguna.career.step5', compact('bidang', 'step3', 'step4'));
    }

    public function storeFinal(CareerStepFinalRequest $request)
    {
        $step1 = session('career_step1');
        $step2 = session('career_step2');
        $step3 = session('career_step3');
        $step4 = session('career_step4');

        if (!$step3 || !$step4) {
            return redirect()->route('pengguna.career.step1')->with('error', 'Sesi telah kedaluwarsa. Silakan mulai ulang.');
        }

        // MIME sniffing tambahan untuk keamanan file
        if ($request->hasFile('file_surat_pengantar')) {
            $file = $request->file('file_surat_pengantar');
            $allowedMimes = ['application/pdf', 'image/jpeg', 'image/png'];
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, $allowedExtensions) || !in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['file_surat_pengantar' => 'Tipe file tidak diizinkan berdasarkan konten file.'])->withInput();
            }
        }

        try {
            $pengajuan = DB::transaction(function () use ($request, $step3, $step4) {
                // Validasi ulang kuota dengan lock (cegah race condition)
                $kuotaValid = $this->kuotaService->validateUlang(
                    $step3['bidang_id'],
                    $step4['tanggal_mulai'],
                    $step3['durasi_bulan']
                );

                if (!$kuotaValid) {
                    throw new \Exception('Slot penuh. Tanggal yang Anda pilih baru saja habis terisi. Silakan pilih tanggal lain.');
                }

                // Generate nomor pengajuan dengan locking
                $nomorPengajuan = $this->pengajuanService->generateNomorPengajuan();

                // Simpan file surat pengantar ke disk private
                $filePath = $request->file('file_surat_pengantar')
                    ->store('surat-pengantar', 'local');

                // Buat record Pengajuan
                $pengajuan = Pengajuan::create([
                    'public_id' => Str::uuid(),
                    'nomor_pengajuan' => $nomorPengajuan,
                    'user_id' => auth()->id(),
                    'jenjang' => $step3['jenjang'],
                    'bidang_id' => $step3['bidang_id'],
                    'keahlian' => $step3['keahlian'],
                    'durasi_bulan' => $step3['durasi_bulan'],
                    'tanggal_mulai' => $step4['tanggal_mulai'],
                    'tanggal_selesai_rencana' => $step4['tanggal_selesai_rencana'],
                    'status' => 'Menunggu Verifikasi',
                    'file_surat_pengantar' => $filePath,
                    'laporan_status' => 'Belum Ada',
                    'skm_saran' => null,
                ]);

                // Catat log status awal
                \App\Models\PengajuanStatusLog::create([
                    'pengajuan_id' => $pengajuan->id,
                    'status' => 'Menunggu Verifikasi',
                    'catatan' => 'Pengajuan dikirim oleh calon peserta.',
                    'created_by' => auth()->id(),
                ]);

                // Notifikasi in-app untuk pengguna
                \App\Models\Notifikasi::create([
                    'user_id' => auth()->id(),
                    'judul' => 'Pengajuan Berhasil Dikirim',
                    'pesan' => "Pengajuan magang Anda dengan nomor {$nomorPengajuan} berhasil dikirim dan sedang menunggu verifikasi petugas.",
                ]);

                return $pengajuan;
            });

            // Bersihkan session career
            session()->forget(['career_step1', 'career_step2', 'career_step3', 'career_step4']);

            return redirect()->route('pengguna.career.konfirmasi', $pengajuan->public_id)
                ->with('success', 'Pengajuan berhasil dikirim!');

        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    // ─── KONFIRMASI ────────────────────────────────────────────────────────
    public function konfirmasi(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('user_id', auth()->id())
            ->with(['bidang', 'bidang.pembimbing'])
            ->firstOrFail();

        return view('pengguna.career.konfirmasi', compact('pengajuan'));
    }

    // ─── API: Kuota Kalender (JSON untuk Alpine.js) ────────────────────────
    public function kuotaKalender(Request $request, Bidang $bidang)
    {
        $request->validate(['durasi' => ['required', 'integer', 'in:2,3,6']]);

        $kalender = $this->kuotaService->getKalenderTersedia($bidang, (int) $request->durasi, 4);

        return response()->json($kalender);
    }
}
