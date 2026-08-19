<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Bidang::count() > 0) {
            return;
        }

        $petugasBudi = User::where('email', 'budi@biogen.go.id')->first();
        $petugasSusi = User::where('email', 'susi@biogen.go.id')->first();

        // Bidang 1: Kultur Jaringan (Mahasiswa)
        $b1 = Bidang::create([
            'nama_bidang' => 'Kultur Jaringan Tanaman',
            'deskripsi' => 'Pengembangan teknik kultur in vitro untuk perbanyakan benih tanaman perkebunan dan hortikultura.',
            'jobdesc' => "1. Preparasi media tumbuh kultur jaringan (MS, WPM, Modifikasi) serta sterilisasi alat & media menggunakan Autoklaf.\n2. Penyiapan eksplan dan pelaksanaan teknik sterilisasi permukaan bahan tanaman.\n3. Subkultur (perbanyakan dan regenerasi tunas) di dalam Laminar Air Flow (LAF) Cabinet.\n4. Pengamatan laju pertumbuhan planlet, pencatatan kontaminasi, dan evaluasi organogenesis.\n5. Aklimatisasi planlet dari botol laboratorium menuju media tanah/cocopeat di Rumah Kaca (Greenhouse).",
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $petugasBudi ? $petugasBudi->id : null,
            'kapasitas' => 8,
            'is_active' => true,
        ]);

        // Bidang 2: Genetika Molekuler (Mahasiswa)
        $b2 = Bidang::create([
            'nama_bidang' => 'Genetika Molekuler',
            'deskripsi' => 'Analisis marka molekuler, isolasi DNA/RNA, dan karakterisasi gen pada komoditas pangan.',
            'jobdesc' => "1. Ekstraksi dan isolasi DNA/RNA genomik dari berbagai jaringan tanaman pangan dan hortikultura.\n2. Pengujian kualitas dan kuantitas hasil isolasi menggunakan Spektrofotometer / NanoDrop.\n3. Optimasi reaksi amplifikasi DNA menggunakan mesin Polymerase Chain Reaction (PCR).\n4. Elektroforesis gel agarosa dan dokumentasi pita sampel DNA menggunakan sistem Gel Doc.\n5. Analisis keragaman genetik dan marka molekuler (SSR/SNP) untuk pemuliaan berbasis marka (MAS).",
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $petugasSusi ? $petugasSusi->id : null,
            'kapasitas' => 8,
            'is_active' => true,
        ]);

        // Bidang 3: Proteksi Tanaman (Siswa)
        $b3 = Bidang::create([
            'nama_bidang' => 'Proteksi Tanaman dan Kultur Jaringan Dasar',
            'deskripsi' => 'Pengenalan dasar kultur jaringan dan penanganan hama penyakit tanaman secara hayati.',
            'jobdesc' => "1. Pengenalan sanitasi laboratorium, sterilisasi alat kaca, dan operasional Autoklaf & LAF.\n2. Identifikasi visual dan mikroskopis gejala serangan hama & penyakit utama tanaman.\n3. Pembuatan media biakan sederhana dan pendampingan perbanyakan agens antagonis/hayati.\n4. Pemeliharaan kebersihan botol kultur dan pencatatan harian kontaminasi cendawan/bakteri.\n5. Pencatatan log harian aktivitas laboratorium proteksi dan inventarisasi bahan praktikum.",
            'jenjang' => 'Siswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $petugasBudi ? $petugasBudi->id : null,
            'kapasitas' => 8,
            'is_active' => true,
        ]);

        // Bidang 4: Administrasi Laboratorium (Siswa)
        $b4 = Bidang::create([
            'nama_bidang' => 'Administrasi dan Pengelolaan Kebun Percobaan',
            'deskripsi' => 'Pembelajaran tata kelola administrasi kebun percobaan, pencatatan plasma nutfah, dan inventarisasi alat.',
            'jobdesc' => "1. Pencatatan inventaris koleksi tanaman plasma nutfah dan logbook pemeliharaan kebun percobaan.\n2. Pengelolaan administrasi masuk-keluar sampel tanaman, benih unggul, dan bahan laboratorium.\n3. Pembuatan rekapitulasi data harian kondisi fisik tanaman percobaan dan cuaca lingkungan kebun.\n4. Pengarsipan dokumen operasional, surat pengantar sampel, dan laporan kegiatan kebun.\n5. Pendataan ketersediaan sarana produksi pertanian (pupuk, media tanam, pestisida, dan sarana greenhouse).",
            'jenjang' => 'Siswa',
            'kategori' => 'Non Pertanian',
            'pembimbing_id' => $petugasSusi ? $petugasSusi->id : null,
            'kapasitas' => 8,
            'is_active' => true,
        ]);

        // Attach multi-petugas with individual kuotas
        if ($petugasBudi && $petugasSusi) {
            foreach ([$b1, $b2, $b3, $b4] as $b) {
                $b->petugasList()->sync([
                    $petugasBudi->id => ['kuota' => 5],
                    $petugasSusi->id => ['kuota' => 3],
                ]);
            }
        }
    }
}
