<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\Notifikasi;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Models\PengajuanStatusLog;
use App\Models\SkmJawaban;
use App\Models\SkmPertanyaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Pengajuan::count() > 0) {
            return;
        }

        $danang = User::where('email', 'danang@example.com')->first();
        $roni = User::where('email', 'roni@example.com')->first();
        $admin = User::where('email', 'admin@biogen.go.id')->first();

        $bidangKultur = Bidang::where('nama_bidang', 'Kultur Jaringan')->first() ?? Bidang::first();
        $bidangMolekuler = Bidang::where('nama_bidang', 'Biologi Molekuler')->first() ?? Bidang::first();
        $bidangAgri = Bidang::where('nama_bidang', 'Agribisnis')->first() ?? Bidang::first();

        $pembimbing = Pembimbing::first();

        $pertanyaans = SkmPertanyaan::all();

        // 1. Pengajuan 1: Menunggu Verifikasi (Danang, Kultur Jaringan)
        if ($danang && $bidangKultur) {
            $p1 = Pengajuan::create([
                'public_id' => Str::uuid(),
                'nomor_pengajuan' => 'PKL-2026-0001',
                'user_id' => $danang->id,
                'jenjang' => 'Mahasiswa',
                'bidang_id' => $bidangKultur->id,
                'pembimbing_id' => $pembimbing?->id,
                'keahlian' => 'Kultur jaringan dasar, sterilisasi eksplan, preparasi media.',
                'durasi_bulan' => 3,
                'tanggal_mulai' => now()->addDays(10)->toDateString(),
                'tanggal_selesai_rencana' => now()->addMonths(3)->toDateString(),
                'status' => 'Menunggu Verifikasi',
                'file_surat_pengantar' => 'surat_pengantar_danang_1.pdf',
                'laporan_status' => 'Belum Ada',
                'skm_saran' => 'Aplikasi pendaftaran ini sangat mudah digunakan.',
            ]);

            $this->createSkmJawaban($p1, $pertanyaans, [4, 4, 4, 4, 3, 4, 4, 4, 4]);
            $this->logStatus($p1, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $danang->id);

            Notifikasi::create([
                'user_id' => $danang->id,
                'judul' => 'Pengajuan Dikirim',
                'pesan' => 'Pengajuan PKL-2026-0001 Anda berhasil dikirim dan sedang menunggu verifikasi admin.',
            ]);
        }

        // 2. Pengajuan 2: Disetujui / Terjadwal (Danang, Biologi Molekuler)
        if ($danang && $bidangMolekuler) {
            $p2 = Pengajuan::create([
                'public_id' => Str::uuid(),
                'nomor_pengajuan' => 'PKL-2026-0002',
                'user_id' => $danang->id,
                'jenjang' => 'Mahasiswa',
                'bidang_id' => $bidangMolekuler->id,
                'pembimbing_id' => $pembimbing?->id,
                'keahlian' => 'PCR, Elektroforesis, Isolasi DNA.',
                'durasi_bulan' => 2,
                'tanggal_mulai' => now()->addDays(20)->toDateString(),
                'tanggal_selesai_rencana' => now()->addMonths(2)->addDays(20)->toDateString(),
                'status' => 'Disetujui',
                'file_surat_pengantar' => 'surat_pengantar_danang_2.pdf',
                'file_surat_balasan' => 'surat_balasan_2.pdf',
                'laporan_status' => 'Belum Ada',
                'skm_saran' => 'Kalender kuota sangat informatif.',
            ]);

            $this->createSkmJawaban($p2, $pertanyaans, [4, 4, 4, 4, 4, 4, 4, 4, 4]);
            $this->logStatus($p2, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $danang->id);
            $this->logStatus($p2, 'Disetujui', 'Dokumen lengkap dan disetujui.', $admin?->id);

            Notifikasi::create([
                'user_id' => $danang->id,
                'judul' => 'Pengajuan Disetujui',
                'pesan' => 'Pengajuan PKL-2026-0002 Anda telah disetujui.',
            ]);
        }

        // 3. Pengajuan 3: Ditolak (Roni, Kultur Jaringan)
        if ($roni && $bidangKultur) {
            $p3 = Pengajuan::create([
                'public_id' => Str::uuid(),
                'nomor_pengajuan' => 'PKL-2026-0003',
                'user_id' => $roni->id,
                'jenjang' => 'Siswa',
                'bidang_id' => $bidangKultur->id,
                'pembimbing_id' => $pembimbing?->id,
                'keahlian' => 'Kultur jaringan.',
                'durasi_bulan' => 3,
                'tanggal_mulai' => now()->addDays(15)->toDateString(),
                'tanggal_selesai_rencana' => now()->addMonths(3)->toDateString(),
                'status' => 'Ditolak',
                'catatan_petugas' => 'Bidang Kultur Jaringan hanya menerima jenjang Mahasiswa.',
                'file_surat_pengantar' => 'surat_pengantar_roni.pdf',
                'laporan_status' => 'Belum Ada',
                'skm_saran' => 'Prosedur mudah.',
            ]);

            $this->createSkmJawaban($p3, $pertanyaans, [4, 4, 3, 4, 2, 4, 4, 4, 4]);
            $this->logStatus($p3, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $roni->id);
            $this->logStatus($p3, 'Ditolak', 'Bidang Kultur Jaringan hanya menerima jenjang Mahasiswa.', $admin?->id);

            Notifikasi::create([
                'user_id' => $roni->id,
                'judul' => 'Pengajuan Ditolak',
                'pesan' => 'Mohon maaf, pengajuan PKL-2026-0003 Anda ditolak. Catatan: Bidang Kultur Jaringan hanya menerima jenjang Mahasiswa.',
            ]);
        }
    }

    /**
     * Helper to write SKM answers.
     */
    private function createSkmJawaban(Pengajuan $pengajuan, $pertanyaans, array $ratings): void
    {
        foreach ($pertanyaans as $index => $pertanyaan) {
            SkmJawaban::create([
                'pengajuan_id' => $pengajuan->id,
                'skm_pertanyaan_id' => $pertanyaan->id,
                'rating' => $ratings[$index] ?? 4,
            ]);
        }
    }

    /**
     * Helper to log status history.
     */
    private function logStatus(Pengajuan $pengajuan, string $status, ?string $catatan, ?int $createdBy = null): void
    {
        PengajuanStatusLog::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => $status,
            'catatan' => $catatan,
            'created_by' => $createdBy,
        ]);
    }
}
