<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\Notifikasi;
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
        $budi = User::where('email', 'budi@biogen.go.id')->first();
        $susi = User::where('email', 'susi@biogen.go.id')->first();

        $bidangKultur = Bidang::where('nama_bidang', 'Kultur Jaringan Tanaman')->first();
        $bidangGenetika = Bidang::where('nama_bidang', 'Genetika Molekuler')->first();
        $bidangProteksi = Bidang::where('nama_bidang', 'Proteksi Tanaman dan Kultur Jaringan Dasar')->first();

        $pertanyaans = SkmPertanyaan::all();

        // 1. Pengajuan 1: Menunggu Verifikasi (Danang, Kultur Jaringan)
        $p1 = Pengajuan::create([
            'public_id' => Str::uuid(),
            'nomor_pengajuan' => 'PKL-2026-0001',
            'user_id' => $danang->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidangKultur->id,
            'keahlian' => 'Kultur jaringan dasar, sterilisasi eksplan, preparasi media.',
            'durasi_bulan' => 3,
            'tanggal_mulai' => '2026-09-01',
            'tanggal_selesai_rencana' => '2026-11-30',
            'status' => 'Menunggu Verifikasi',
            'file_surat_pengantar' => 'surat_pengantar_danang_1.pdf',
            'laporan_status' => 'Belum Ada',
            'skm_saran' => 'Aplikasi pendaftaran ini sangat mudah digunakan.',
        ]);

        $this->createSkmJawaban($p1, $pertanyaans, [5, 4, 5, 5, 4, 5, 4, 5, 5]);
        $this->logStatus($p1, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $danang->id);

        Notifikasi::create([
            'user_id' => $danang->id,
            'judul' => 'Pengajuan Dikirim',
            'pesan' => 'Pengajuan magang PKL-2026-0001 Anda berhasil dikirim dan sedang menunggu verifikasi petugas.',
        ]);


        // 2. Pengajuan 2: Terjadwal (Danang, Genetika Molekuler)
        $p2 = Pengajuan::create([
            'public_id' => Str::uuid(),
            'nomor_pengajuan' => 'PKL-2026-0002',
            'user_id' => $danang->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidangGenetika->id,
            'keahlian' => 'PCR, Elektroforesis, Isolasi DNA.',
            'durasi_bulan' => 2,
            'tanggal_mulai' => '2026-10-01',
            'tanggal_selesai_rencana' => '2026-11-30',
            'status' => 'Terjadwal',
            'file_surat_pengantar' => 'surat_pengantar_danang_2.pdf',
            'laporan_status' => 'Belum Ada',
            'skm_saran' => 'Kalender kuota sangat informatif.',
        ]);

        $this->createSkmJawaban($p2, $pertanyaans, [5, 5, 5, 5, 5, 5, 5, 5, 5]);
        $this->logStatus($p2, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $danang->id);
        $this->logStatus($p2, 'Disetujui', 'Dokumen lengkap dan bidang sesuai.', $budi->id);
        $this->logStatus($p2, 'Terjadwal', 'Menunggu tanggal mulai magang.', null);

        Notifikasi::create([
            'user_id' => $danang->id,
            'judul' => 'Pengajuan Disetujui',
            'pesan' => 'Pengajuan magang PKL-2026-0002 Anda telah disetujui. Status saat ini: Terjadwal.',
        ]);


        // 3. Pengajuan 3: Sedang Magang (Roni, Proteksi Tanaman)
        $p3 = Pengajuan::create([
            'public_id' => Str::uuid(),
            'nomor_pengajuan' => 'PKL-2026-0003',
            'user_id' => $roni->id,
            'jenjang' => 'Siswa',
            'bidang_id' => $bidangProteksi->id,
            'keahlian' => 'Identifikasi hama, pembuatan pestisida nabati.',
            'durasi_bulan' => 2,
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai_rencana' => '2026-08-31',
            'status' => 'Sedang Magang',
            'file_surat_pengantar' => 'surat_pengantar_roni.pdf',
            'laporan_status' => 'Belum Ada',
            'skm_saran' => 'Sangat membantu mempermudah pendaftaran sekolah.',
        ]);

        $this->createSkmJawaban($p3, $pertanyaans, [4, 4, 5, 5, 4, 4, 5, 4, 4]);
        $this->logStatus($p3, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $roni->id);
        $this->logStatus($p3, 'Disetujui', 'Dokumen diverifikasi.', $susi->id);
        $this->logStatus($p3, 'Terjadwal', 'Terjadwal masuk magang.', null);
        $this->logStatus($p3, 'Sedang Magang', 'Mulai pelaksanaan magang.', null);

        Notifikasi::create([
            'user_id' => $roni->id,
            'judul' => 'Pelaksanaan Magang Dimulai',
            'pesan' => 'Selamat, masa pelaksanaan magang PKL-2026-0003 Anda telah dimulai hari ini.',
        ]);


        // 4. Pengajuan 4: Selesai (Danang, Kultur Jaringan)
        $p4 = Pengajuan::create([
            'public_id' => Str::uuid(),
            'nomor_pengajuan' => 'PKL-2026-0004',
            'user_id' => $danang->id,
            'jenjang' => 'Mahasiswa',
            'bidang_id' => $bidangKultur->id,
            'keahlian' => 'Optimasi media MS, subkultur eksplan.',
            'durasi_bulan' => 3,
            'tanggal_mulai' => '2026-02-01',
            'tanggal_selesai_rencana' => '2026-04-30',
            'status' => 'Selesai',
            'file_surat_pengantar' => 'surat_pengantar_danang_old.pdf',
            'file_laporan_akhir' => 'laporan_akhir_danang.pdf',
            'laporan_status' => 'Diterima',
            'file_surat_keterangan' => 'surat_keterangan_selesai_danang.pdf',
            'skm_saran' => 'Pelayanan BRMP Biogen luar biasa baik.',
        ]);

        $this->createSkmJawaban($p4, $pertanyaans, [5, 5, 5, 5, 5, 5, 5, 5, 5]);
        $this->logStatus($p4, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $danang->id);
        $this->logStatus($p4, 'Disetujui', 'Diterima untuk magang.', $budi->id);
        $this->logStatus($p4, 'Terjadwal', 'Terjadwal magang.', null);
        $this->logStatus($p4, 'Sedang Magang', 'Sedang melaksanakan magang.', null);
        $this->logStatus($p4, 'Selesai', 'Magang selesai, sertifikat diterbitkan.', $budi->id);

        Notifikasi::create([
            'user_id' => $danang->id,
            'judul' => 'Sertifikat Selesai Tersedia',
            'pesan' => 'Laporan Akhir Anda disetujui. Surat Keterangan Selesai Magang Anda dapat diunduh sekarang.',
        ]);


        // 5. Pengajuan 5: Ditolak (Roni, Kultur Jaringan)
        $p5 = Pengajuan::create([
            'public_id' => Str::uuid(),
            'nomor_pengajuan' => 'PKL-2026-0005',
            'user_id' => $roni->id,
            'jenjang' => 'Siswa',
            'bidang_id' => $bidangKultur->id, // Kultur Jaringan is for Mahasiswa, so it gets rejected
            'keahlian' => 'Kultur jaringan.',
            'durasi_bulan' => 3,
            'tanggal_mulai' => '2026-09-01',
            'tanggal_selesai_rencana' => '2026-11-30',
            'status' => 'Ditolak',
            'catatan_petugas' => 'Bidang Kultur Jaringan Tanaman hanya menerima jenjang Mahasiswa pada tanggal tersebut. Silakan pilih bidang lain yang sesuai.',
            'file_surat_pengantar' => 'surat_pengantar_roni_failed.pdf',
            'laporan_status' => 'Belum Ada',
            'skm_saran' => 'Prosedur mudah, sayangnya saya salah memilih bidang.',
        ]);

        $this->createSkmJawaban($p5, $pertanyaans, [4, 4, 3, 5, 2, 4, 4, 4, 4]);
        $this->logStatus($p5, 'Menunggu Verifikasi', 'Pengajuan diajukan oleh calon peserta.', $roni->id);
        $this->logStatus($p5, 'Ditolak', 'Bidang Kultur Jaringan Tanaman hanya menerima jenjang Mahasiswa pada tanggal tersebut. Silakan pilih bidang lain yang sesuai.', $susi->id);

        Notifikasi::create([
            'user_id' => $roni->id,
            'judul' => 'Pengajuan Ditolak',
            'pesan' => 'Mohon maaf, pengajuan PKL-2026-0005 Anda ditolak. Catatan: Bidang Kultur Jaringan hanya menerima jenjang Mahasiswa.',
        ]);
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
                'rating' => $ratings[$index] ?? 5,
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
