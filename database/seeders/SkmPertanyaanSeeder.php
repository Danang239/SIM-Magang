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
            'Informasi pelayanan tersedia melalui media elektronik maupun nonelektronik',
            'Kesesuaian persyaratan dengan standar pelayanan/Informasi yang diberikan',
            'Standar dan prosedur layanan diinformasikan dengan jelas',
            'Prosedur/Alur layanan mudah dipahami dan dilakukan',
            'Layanan diberikan sesuai prosedur tanpa kecurangan',
            'Jangka waktu layanan sesuai dengan standar pelayanan/ yang diinformasikan',
            'Biaya layanan sesuai dengan standar pelayanan/ yang diinformasikan',
            'Tidak ada pungutan liar (pungli) dalam pelayanan',
            'Tidak ada percaloan/perantara tidak resmi dalam pelayanan',
            'Produk layanan yang diterima sesuai dengan standar pelayanan / yang dipublikasikan',
            'Petugas merespon kebutuhan dengan cepat',
            'Petugas melayani saya dengan ramah',
            'Seluruh pengguna layanan dilayani secara adil tanpa diskriminasi',
            'Pelayanan diberikan tanpa imbalan uang, barang, atau fasilitas di luar aturan',
            'Layanan konsultasi dan pengaduan mudah diakses',
            'Sarana prasarana nyaman dan mudah digunakan',
        ];

        foreach ($pertanyaan as $index => $teks) {
            SkmPertanyaan::updateOrCreate(
                ['urutan' => $index + 1],
                [
                    'teks_pertanyaan' => $teks,
                    'is_active' => true,
                ]
            );
        }
    }
}
