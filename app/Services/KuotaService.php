<?php

namespace App\Services;

use App\Models\Bidang;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KuotaService
{
    /**
     * Status pengajuan yang dianggap "aktif" dan mengonsumsi slot kuota.
     */
    protected array $statusAktif = ['Disetujui', 'Terjadwal', 'Sedang Magang'];

    /**
     * Hitung jumlah pengajuan aktif yang overlap dengan rentang tanggal tertentu.
     * Digunakan untuk kalender front-end.
     *
     * @param  int    $bidangId
     * @param  string $tanggal     Format: Y-m-d
     * @param  int    $durasiBuilan
     * @return int    Jumlah slot yang sudah terisi
     */
    public function hitungSlotTerisi(int $bidangId, string $tanggal, int $durasiBulan): int
    {
        $tanggalMulai = Carbon::parse($tanggal)->startOfDay();
        $tanggalSelesai = $tanggalMulai->copy()->addMonths($durasiBulan)->subDay()->endOfDay();

        return Pengajuan::where('bidang_id', $bidangId)
            ->whereIn('status', $this->statusAktif)
            ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                    // Pengajuan yang mulainya ada di dalam rentang kita
                    $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                      ->where('tanggal_selesai_rencana', '>=', $tanggalMulai);
                });
            })
            ->count();
    }

    /**
     * Generate data kalender ketersediaan untuk bulan-bulan tertentu.
     * Mengembalikan array tanggal beserta status ketersediaannya.
     *
     * @param  Bidang $bidang
     * @param  int    $durasiBulan
     * @param  int    $bulanKedepan  Berapa bulan ke depan yang ditampilkan
     * @return array  [ 'Y-m-d' => ['tersedia' => bool, 'terisi' => int, 'kapasitas' => int] ]
     */
    public function getKalenderTersedia(Bidang $bidang, int $durasiBulan, int $bulanKedepan = 3): array
    {
        $hasil = [];
        $today = Carbon::today();
        $akhir = $today->copy()->addMonths($bulanKedepan);

        // Iterasi setiap hari dari besok sampai batas
        $tanggal = $today->copy()->addDay();
        while ($tanggal->lte($akhir)) {
            $tanggalStr = $tanggal->toDateString();
            $terisi = $this->hitungSlotTerisi($bidang->id, $tanggalStr, $durasiBulan);

            $hasil[$tanggalStr] = [
                'tersedia' => $terisi < $bidang->kapasitas,
                'terisi' => $terisi,
                'kapasitas' => $bidang->kapasitas,
                'slot_sisa' => max(0, $bidang->kapasitas - $terisi),
            ];

            $tanggal->addDay();
        }

        return $hasil;
    }

    /**
     * Validasi ulang ketersediaan slot DENGAN lockForUpdate() untuk mencegah race condition.
     * Dipanggil di dalam DB::transaction() pada submit akhir.
     *
     * @param  int    $bidangId
     * @param  string $tanggalMulai   Format: Y-m-d
     * @param  int    $durasiBulan
     * @return bool   true = masih tersedia, false = penuh
     * @throws \Exception
     */
    public function validateUlang(int $bidangId, string $tanggalMulai, int $durasiBulan): bool
    {
        $bidang = Bidang::lockForUpdate()->findOrFail($bidangId);

        $tanggalMulaiCarbon = Carbon::parse($tanggalMulai)->startOfDay();
        $tanggalSelesai = $tanggalMulaiCarbon->copy()->addMonths($durasiBulan)->subDay()->endOfDay();

        $terisi = Pengajuan::where('bidang_id', $bidangId)
            ->whereIn('status', $this->statusAktif)
            ->where(function ($query) use ($tanggalMulaiCarbon, $tanggalSelesai) {
                $query->where('tanggal_mulai', '<=', $tanggalSelesai)
                      ->where('tanggal_selesai_rencana', '>=', $tanggalMulaiCarbon);
            })
            ->lockForUpdate()
            ->count();

        return $terisi < $bidang->kapasitas;
    }
}
