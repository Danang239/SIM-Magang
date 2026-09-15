<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Kategori Mahasiswa
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Biologi molekuler',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 4,
                'deskripsi' => 'Analisis DNA, marka molekuler, dan rekayasa genetika tanaman bagi siswa dan mahasiswa.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Kultur jaringan',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 4,
                'deskripsi' => 'Perbanyakan tanaman secara in-vitro dan optimasi media tumbuh tanaman.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Bank Gen Pertanian',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 4,
                'deskripsi' => 'Konservasi, karakterisasi, evaluasi, dan manajemen data sumber daya genetik plasma nutfah pertanian.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Hubungan Masyarakat',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 2,
                'deskripsi' => 'Komunikasi publik, publikasi ilmiah, protokoler, dan dokumentasi kegiatan institusi.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Teknologi Informasi',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 5,
                'deskripsi' => 'Pengelolaan infrastruktur TI, pemeliharaan sistem informasi, basis data, jaringan komputer, dan dukungan komputasi riset.',
                'is_active' => true,
            ],

            // Kategori Siswa
            [
                'kategori' => 'Siswa',
                'nama_bidang' => 'Bank Gen Pertanian',
                'jenjang' => 'Siswa',
                'kapasitas' => 4,
                'deskripsi' => 'Pemeliharaan koleksi benih plasma nutfah dan pengelolaan ruang simpan bank gen.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Siswa',
                'nama_bidang' => 'Unit Pengelola Benih Sumber (UPBS)',
                'jenjang' => 'Siswa',
                'kapasitas' => 4,
                'deskripsi' => 'Unit Pengelola Benih Sumber (UPBS) untuk produksi, pemurnian, dan distribusi benih sumber bersertifikat.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Siswa',
                'nama_bidang' => 'Perkantoran',
                'jenjang' => 'Siswa',
                'kapasitas' => 6,
                'deskripsi' => 'Administrasi perkantoran dan manajemen dokumen pendukung riset.',
                'is_active' => true,
            ],
        ];

        // 1. Simpan / Update data 8 bidang resmi (matching both nama_bidang and jenjang)
        $bidangMap = [];
        foreach ($data as $item) {
            $bidang = Bidang::updateOrCreate(
                ['nama_bidang' => $item['nama_bidang'], 'jenjang' => $item['jenjang']],
                $item
            );
            $bidangMap[$item['nama_bidang'] . '_' . $item['jenjang']] = $bidang->id;
        }

        // 2. Hubungkan dengan pembimbing jika ada
        if (Schema::hasTable('pembimbings')) {
            $pembimbingIds = Pembimbing::where('is_active', true)->pluck('id')->toArray();
            if (!empty($pembimbingIds)) {
                foreach ($bidangMap as $bidangId) {
                    $hasPivot = DB::table('bidang_pembimbing')->where('bidang_id', $bidangId)->exists();
                    if (!$hasPivot) {
                        foreach ($pembimbingIds as $pId) {
                            DB::table('bidang_pembimbing')->updateOrInsert(
                                ['bidang_id' => $bidangId, 'pembimbing_id' => $pId],
                                ['kuota' => 5, 'created_at' => now(), 'updated_at' => now()]
                            );
                        }
                    }
                }
            }
        }
    }
}
