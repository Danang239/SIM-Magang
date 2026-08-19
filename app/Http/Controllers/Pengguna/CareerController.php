<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerStepFinalRequest;
use App\Http\Requests\CareerStepTanggalRequest;
use App\Models\Bidang;
use App\Models\Pengajuan;
use App\Services\KuotaService;
use App\Services\PengajuanService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    public function __construct(
        protected KuotaService $kuotaService,
        protected PengajuanService $pengajuanService,
    ) {}

    // ─── STEP 1: Pilih Durasi, Keahlian & Tanggal ────────────────────────────
    public function step1(Request $request)
    {
        $bidangId = $request->query('bidang_id') ?? session('bidang_id');
        if (!$bidangId) {
            return redirect()->route('home')->with('error', 'Silakan pilih bidang magang terlebih dahulu.');
        }

        // Simpan ke session
        session(['bidang_id' => $bidangId]);
        if ($request->has('pembimbing_id')) {
            session(['pembimbing_id' => $request->query('pembimbing_id')]);
        }

        $bidang = Bidang::with('pembimbing')->findOrFail($bidangId);
        
        if (!$request->has('resume')) {
            session()->forget(['career_step1']);
        }

        $step1Data = session('career_step1', []);

        // Indikator kalender awal dengan durasi default 2 bulan
        $durasiDefault = isset($step1Data['durasi_bulan']) ? (int) $step1Data['durasi_bulan'] : 2;
        $kalender = $this->kuotaService->getKalenderTersedia($bidang, $durasiDefault, 4);

        return view('pengguna.career.step1', compact('bidang', 'step1Data', 'kalender', 'durasiDefault'));
    }

    public function step1Store(CareerStepTanggalRequest $request)
    {
        $validated = $request->validated();
        $bidangId = session('bidang_id');

        if (!$bidangId) {
            return redirect()->route('home')->with('error', 'Bidang belum dipilih.');
        }

        $tanggalMulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggalSelesai = $tanggalMulai->copy()->addMonths((int) $validated['durasi_bulan'])->subDay();

        session(['career_step1' => [
            'bidang_id' => $bidangId,
            'durasi_bulan' => $validated['durasi_bulan'],
            'keahlian' => $validated['keahlian'],
            'tanggal_mulai' => $tanggalMulai->toDateString(),
            'tanggal_selesai_rencana' => $tanggalSelesai->toDateString(),
        ]]);

        return redirect()->route('pengguna.career.step2');
    }

    // ─── STEP 2: Biodata Lengkap & Upload Surat Pengantar & S&K ─────────────
    public function step2()
    {
        $step1 = session('career_step1');
        $bidangId = session('bidang_id');

        if (!$step1 || !$bidangId) {
            return redirect()->route('pengguna.career.step1')->with('error', 'Silakan lengkapi langkah 1 terlebih dahulu.');
        }

        $bidang = Bidang::with('pembimbing')->findOrFail($bidangId);

        return view('pengguna.career.step2', compact('bidang', 'step1'));
    }

    public function storeFinal(CareerStepFinalRequest $request)
    {
        $step1 = session('career_step1');
        $bidangId = session('bidang_id');

        if (!$step1 || !$bidangId) {
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
            $pengajuan = DB::transaction(function () use ($request, $step1, $bidangId) {
                // Validasi ulang kuota dengan lock (cegah race condition)
                $kuotaValid = $this->kuotaService->validateUlang(
                    $bidangId,
                    $step1['tanggal_mulai'],
                    $step1['durasi_bulan']
                );

                if (!$kuotaValid) {
                    throw new \Exception('Slot penuh. Tanggal yang Anda pilih baru saja habis terisi. Silakan pilih tanggal lain.');
                }

                // Generate nomor pengajuan dengan locking
                $nomorPengajuan = $this->pengajuanService->generateNomorPengajuan();

                // Simpan file surat pengantar & foto 4x6 ke disk private
                $filePath = $request->file('file_surat_pengantar')
                    ->store('surat-pengantar', 'local');

                $fotoDiriPath = null;
                if ($request->hasFile('foto_diri')) {
                    $fotoDiriPath = $request->file('foto_diri')
                        ->store('foto-diri', 'local');
                    $fullPath = storage_path('app/' . $fotoDiriPath);
                    $this->cropAndResizeTo4x6($fullPath, $fullPath);
                }

                $bidang = Bidang::findOrFail($bidangId);

                // Update profil pengguna (no_hp, instansi, program_studi) agar selalu terisi lengkap
                $user = auth()->user();
                $user->update([
                    'no_hp' => $request->no_hp,
                    'instansi' => $request->instansi,
                    'program_studi' => $request->program_studi,
                ]);

                // Buat record Pengajuan
                $pengajuan = Pengajuan::create([
                    'public_id' => Str::uuid(),
                    'nomor_pengajuan' => $nomorPengajuan,
                    'user_id' => $user->id,
                    'foto_diri' => $fotoDiriPath,
                    'jenjang' => $bidang->jenjang,
                    'bidang_id' => $bidangId,
                    'pembimbing_id' => $request->pembimbing_id ?? session('pembimbing_id'),
                    'keahlian' => $step1['keahlian'],
                    'durasi_bulan' => $step1['durasi_bulan'],
                    'tanggal_mulai' => $step1['tanggal_mulai'],
                    'tanggal_selesai_rencana' => $step1['tanggal_selesai_rencana'],
                    'status' => 'Menunggu Verifikasi',
                    'file_surat_pengantar' => $filePath,
                    'laporan_status' => 'Belum Ada',
                    'skm_saran' => null,
                    // Form-1 Biodata & Instansi
                    'nik_ktp' => $request->nik_ktp,
                    'nim_nisn' => $request->nim_nisn,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'nama_pimpinan_instansi' => $request->nama_pimpinan_instansi,
                    'alamat_instansi' => $request->alamat_instansi,
                    'kontak_instansi' => $request->kontak_instansi,
                    'fakultas' => $request->fakultas,
                    'tahun_masuk' => $request->tahun_masuk,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'semester_saat_ini' => $request->semester_saat_ini,
                    'judul_magang' => $request->judul_magang,
                    'tujuan_magang' => $request->tujuan_magang,
                    'nama_dosen_pembimbing' => $request->nama_dosen_pembimbing,
                    'tanda_tangan_digital' => $request->tanda_tangan_digital,
                    'kontak_darurat_nama' => $request->kontak_darurat_nama,
                    'kontak_darurat_no' => $request->kontak_darurat_no,
                    'hubungan_kontak_darurat' => $request->hubungan_kontak_darurat,
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
            session()->forget(['career_step1', 'bidang_id']);

            // Kirim notifikasi email ke Pembimbing bidang jika ada dan memiliki email
            try {
                if ($pengajuan->bidang && $pengajuan->bidang->pembimbing && $pengajuan->bidang->pembimbing->email) {
                    \Illuminate\Support\Facades\Mail::to($pengajuan->bidang->pembimbing->email)
                        ->send(new \App\Mail\PengajuanBaruMasukMail($pengajuan->id));
                }
            } catch (\Exception $mailException) {
                // Skip email failure to avoid breaking the application submit flow
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email pengajuan baru: ' . $mailException->getMessage());
            }

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
        $request->validate(['durasi' => ['required', 'integer', 'in:2,3,4,5,6']]);

        $kalender = $this->kuotaService->getKalenderTersedia($bidang, (int) $request->durasi, 4);

        return response()->json($kalender);
    }

    /**
     * Potong otomatis (crop) dan ubah ukuran foto menjadi 400x600 px (Rasio 4x6 pas foto)
     */
    private function cropAndResizeTo4x6(string $sourcePath, string $destinationPath): void
    {
        if (!file_exists($sourcePath)) {
            return;
        }

        $info = @getimagesize($sourcePath);
        if (!$info) {
            return;
        }

        $mime = $info['mime'];
        $srcImage = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($sourcePath),
            'image/png' => @imagecreatefrompng($sourcePath),
            'image/webp' => @imagecreatefromwebp($sourcePath),
            default => null,
        };

        if (!$srcImage) {
            return;
        }

        $origW = imagesx($srcImage);
        $origH = imagesy($srcImage);

        // Target aspect ratio 4:6 (2:3 = 0.66666...)
        $targetAspect = 4 / 6;
        $origAspect = $origW / $origH;

        if ($origAspect > $targetAspect) {
            // Landscape atau lebih lebar -> potong sisi kiri & kanan
            $cropH = $origH;
            $cropW = (int) round($origH * $targetAspect);
            $cropX = (int) round(($origW - $cropW) / 2);
            $cropY = 0;
        } else {
            // Portrait lebih tinggi -> potong sisi atas & bawah
            $cropW = $origW;
            $cropH = (int) round($origW / $targetAspect);
            $cropX = 0;
            $cropY = (int) round(($origH - $cropH) / 2);
        }

        $targetW = 400;
        $targetH = 600;
        $dstImage = imagecreatetruecolor($targetW, $targetH);

        if ($mime === 'image/png') {
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);
        }

        imagecopyresampled(
            $dstImage,
            $srcImage,
            0, 0,
            $cropX, $cropY,
            $targetW, $targetH,
            $cropW, $cropH
        );

        if ($mime === 'image/png') {
            imagepng($dstImage, $destinationPath, 8);
        } else {
            imagejpeg($dstImage, $destinationPath, 85);
        }

        imagedestroy($srcImage);
        imagedestroy($dstImage);
    }
}
