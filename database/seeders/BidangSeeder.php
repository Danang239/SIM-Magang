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
        $petugasBudi = User::where('email', 'budi@biogen.go.id')->first();
        $petugasSusi = User::where('email', 'susi@biogen.go.id')->first();

        // Bidang 1: Kultur Jaringan (Mahasiswa)
        Bidang::create([
            'nama_bidang' => 'Kultur Jaringan Tanaman',
            'deskripsi' => 'Pengembangan teknik kultur in vitro untuk perbanyakan benih tanaman perkebunan dan hortikultura.',
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $petugasBudi ? $petugasBudi->id : null,
            'kapasitas' => 5,
            'is_active' => true,
        ]);

        // Bidang 2: Genetika Molekuler (Mahasiswa)
        Bidang::create([
            'nama_bidang' => 'Genetika Molekuler',
            'deskripsi' => 'Analisis marka molekuler, isolasi DNA/RNA, dan karakterisasi gen pada komoditas pangan.',
            'jenjang' => 'Mahasiswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $petugasSusi ? $petugasSusi->id : null,
            'kapasitas' => 5,
            'is_active' => true,
        ]);

        // Bidang 3: Proteksi Tanaman (Siswa)
        Bidang::create([
            'nama_bidang' => 'Proteksi Tanaman dan Kultur Jaringan Dasar',
            'deskripsi' => 'Pengenalan dasar kultur jaringan dan penanganan hama penyakit tanaman secara hayati.',
            'jenjang' => 'Siswa',
            'kategori' => 'Pertanian',
            'pembimbing_id' => $petugasBudi ? $petugasBudi->id : null,
            'kapasitas' => 5,
            'is_active' => true,
        ]);

        // Bidang 4: Administrasi Laboratorium (Siswa)
        Bidang::create([
            'nama_bidang' => 'Administrasi dan Pengelolaan Kebun Percobaan',
            'deskripsi' => 'Pembelajaran tata kelola administrasi kebun percobaan, pencatatan plasma nutfah, dan inventarisasi alat.',
            'jenjang' => 'Siswa',
            'kategori' => 'Non Pertanian',
            'pembimbing_id' => $petugasSusi ? $petugasSusi->id : null,
            'kapasitas' => 5,
            'is_active' => true,
        ]);
    }
}
