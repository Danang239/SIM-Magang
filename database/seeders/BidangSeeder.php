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
                'jobdesc' => "1. Ekstraksi DNA/RNA dari sampel jaringan tanaman.\n2. Mengoperasikan mesin PCR dan elektroforesis gel agarosa.\n3. Membantu preparasi bahan dan reagen molekuler.\n4. Analisis data dasar hasil sequencing atau kuantifikasi DNA.",
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Kultur jaringan',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 4,
                'deskripsi' => 'Perbanyakan tanaman secara in-vitro dan optimasi media tumbuh tanaman.',
                'jobdesc' => "1. Pembuatan dan sterilisasi media kultur (MS, WPM, dll).\n2. Membantu proses sterilisasi eksplan dari lapangan.\n3. Melakukan subkultur tanaman secara aseptik di dalam laminar air flow.\n4. Aklimatisasi planlet dari botol kultur ke rumah kaca.",
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Bank gen pertanian',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 3,
                'deskripsi' => 'Konservasi, karakterisasi, dan manajemen data sumber daya genetik tanaman pangan.',
                'jobdesc' => "1. Membantu inventarisasi dan pelabelan koleksi plasma nutfah.\n2. Melakukan uji viabilitas benih secara periodik.\n3. Membantu karakterisasi morfologi tanaman di lapangan atau rumah kaca.\n4. Input data sumber daya genetik ke dalam sistem basis data.",
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Hubungan Masyarakat',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 2,
                'deskripsi' => 'Komunikasi publik, publikasi ilmiah, dan dokumentasi kegiatan institusi.',
                'jobdesc' => "1. Membantu pembuatan konten kreatif (desain grafis/video) untuk media sosial institusi.\n2. Mendokumentasikan (foto/video) kegiatan kunjungan atau acara resmi.\n3. Membantu penyusunan naskah press release berita.\n4. Menganalisis engagement media sosial secara berkala.",
                'is_active' => true,
            ],
            [
                'kategori' => 'Mahasiswa',
                'nama_bidang' => 'Teknologi Informasi',
                'jenjang' => 'Mahasiswa',
                'kapasitas' => 3,
                'deskripsi' => 'Pengembangan sistem informasi riset, jaringan, dan manajemen data bioinformatika.',
                'jobdesc' => "1. Membantu pengembangan aplikasi atau website portal internal institusi.\n2. Pemeliharaan basis data (database) riset.\n3. Mendukung kegiatan pengolahan data menggunakan bahasa pemrograman (Python/R/PHP).\n4. Troubleshooting hardware/software dan infrastruktur jaringan di lingkungan kantor.",
                'is_active' => true,
            ],

            // Kategori Siswa
            [
                'kategori' => 'Siswa',
                'nama_bidang' => 'Bank Gen Pertanian',
                'jenjang' => 'Siswa',
                'kapasitas' => 4,
                'deskripsi' => 'Pemeliharaan koleksi benih plasma nutfah dan pengelolaan ruang simpan bank gen.',
                'jobdesc' => "1. Membantu pembersihan dan sortasi benih tanaman hasil panen.\n2. Melakukan pengeringan dan pengemasan benih untuk penyimpanan jangka menengah/panjang.\n3. Membantu pengecekan suhu dan kelembaban ruang simpan bank gen.",
                'is_active' => true,
            ],
            [
                'kategori' => 'Siswa',
                'nama_bidang' => 'Unit Pengelola Benih Sumber (UPBS)',
                'jenjang' => 'Siswa',
                'kapasitas' => 4,
                'deskripsi' => 'Unit Pengelola Benih Sumber (UPBS) untuk produksi, pemurnian, dan distribusi benih sumber bersertifikat.',
                'jobdesc' => "1. Membantu proses penanaman dan pemeliharaan tanaman benih sumber di kebun percobaan.\n2. Melakukan rouging (pembuangan tanaman tipe simpang).\n3. Membantu proses pengolahan, pengeringan, dan pengemasan benih berlabel resmi.\n4. Membantu pencatatan stok dan distribusi benih sumber.",
                'is_active' => true,
            ],
            [
                'kategori' => 'Siswa',
                'nama_bidang' => 'Perkantoran',
                'jenjang' => 'Siswa',
                'kapasitas' => 6,
                'deskripsi' => 'Administrasi perkantoran dan manajemen dokumen pendukung riset.',
                'jobdesc' => "1. Melakukan pengarsipan dokumen dan surat masuk/keluar.\n2. Membantu rekapitulasi data absensi dan kepegawaian.\n3. Mendukung pelayanan administrasi tamu atau peserta magang lainnya.",
                'is_active' => true,
            ],
        ];

        // 1. Simpan / Update data 8 bidang resmi
        $allowedNames = [];
        $bidangMapByName = [];
        foreach ($data as $item) {
            $allowedNames[] = $item['nama_bidang'];
            $bidang = Bidang::updateOrCreate(
                ['nama_bidang' => $item['nama_bidang']],
                $item
            );
            $bidangMapByName[$item['nama_bidang']] = $bidang->id;
        }

        // 2. Hubungkan dengan pembimbing jika ada
        if (Schema::hasTable('pembimbings')) {
            $pembimbingIds = Pembimbing::where('is_active', true)->pluck('id')->toArray();
            if (!empty($pembimbingIds)) {
                foreach ($bidangMapByName as $bidangId) {
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

        // 3. Cari bidang-bidang lama yang TIDAK ada dalam list 8 bidang resmi dan relokasikan relasi pengajuannya
        $obsoleteBidangs = Bidang::whereNotIn('nama_bidang', $allowedNames)->get();

        foreach ($obsoleteBidangs as $oldBidang) {
            $targetNewId = match (true) {
                str_contains(strtolower($oldBidang->nama_bidang), 'kultur') => $bidangMapByName['Kultur jaringan'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'molekuler') => $bidangMapByName['Biologi molekuler'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'informatika') || str_contains(strtolower($oldBidang->nama_bidang), 'teknologi') => $bidangMapByName['Teknologi Informasi'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'humas') || str_contains(strtolower($oldBidang->nama_bidang), 'masyarakat') => $bidangMapByName['Hubungan Masyarakat'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'upbs') || str_contains(strtolower($oldBidang->nama_bidang), 'sumber') => $bidangMapByName['Unit Pengelola Benih Sumber (UPBS)'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'bank gen') && strtolower($oldBidang->jenjang) === 'siswa' => $bidangMapByName['Bank Gen Pertanian'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'bank gen') => $bidangMapByName['Bank gen pertanian'] ?? null,
                str_contains(strtolower($oldBidang->nama_bidang), 'kebun') || str_contains(strtolower($oldBidang->nama_bidang), 'administrasi') || str_contains(strtolower($oldBidang->nama_bidang), 'perkantoran') => $bidangMapByName['Perkantoran'] ?? null,
                default => $bidangMapByName['Biologi molekuler'] ?? null,
            };

            if ($targetNewId) {
                Pengajuan::where('bidang_id', $oldBidang->id)->update(['bidang_id' => $targetNewId]);
            }

            if (Schema::hasTable('bidang_pembimbing')) {
                DB::table('bidang_pembimbing')->where('bidang_id', $oldBidang->id)->delete();
            }

            $oldBidang->delete();
        }
    }
}
