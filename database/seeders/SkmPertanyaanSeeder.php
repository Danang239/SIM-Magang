<?php

namespace Database\Seeders;

use App\Models\SkmPertanyaan;
use Illuminate\Database\Seeder;

class SkmPertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pertanyaan = [
            'Persyaratan pengajuan magang/PKL di sistem ini mudah dipahami dan tidak memberatkan.',
            'Alur/prosedur pengajuan pada sistem ini jelas dan tidak berbelit-belit.',
            'Waktu proses verifikasi pengajuan oleh petugas cukup cepat.',
            'Pengajuan magang/PKL ini tidak dipungut biaya apa pun.',
            'Informasi bidang penempatan yang tersedia jelas dan sesuai kebutuhan saya.',
            'Petugas yang menangani pengajuan menunjukkan kompetensi/pemahaman yang baik.',
            'Petugas bersikap sopan dan responsif dalam melayani.',
            'Sistem/aplikasi ini mudah diakses dan digunakan.',
            'Instansi menyediakan sarana pengaduan/kontak yang jelas jika saya mengalami kendala.',
        ];

        foreach ($pertanyaan as $index => $teks) {
            SkmPertanyaan::create([
                'teks_pertanyaan' => $teks,
                'urutan' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
