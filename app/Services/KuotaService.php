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
    protected array $statusAktif = ['Menunggu Verifikasi', 'Disetujui', 'Terjadwal', 'Sedang Magang', 'Aktif'];

    /**
     * Hitung jumlah pengajuan aktif yang overlap dengan rentang tanggal tertentu.
     * Digunakan untuk kalender front-end.
     *
     * @param  int       $bidangId
     * @param  string    $tanggal        Format: Y-m-d
     * @param  int       $durasiBulan
     * @param  int|null  $pembimbingId
     * @return int       Jumlah slot yang sudah terisi
     */
    public function hitungSlotTerisi(int $bidangId, string $tanggal, int $durasiBulan, ?int $pembimbingId = null): int
    {
        $tanggalMulai = Carbon::parse($tanggal)->startOfDay();
        $tanggalSelesai = $tanggalMulai->copy()->addMonths($durasiBulan)->subDay()->endOfDay();

        $query = Pengajuan::where('bidang_id', $bidangId)
            ->whereIn('status', $this->statusAktif)
            ->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                  ->where('tanggal_selesai_rencana', '>=', $tanggalMulai);
            });

        if ($pembimbingId) {
            $query->where('pembimbing_id', $pembimbingId);
        }

        return $query->count();
    }

    /**
     * Dapatkan kapasitas maksimal untuk bidang / pembimbing
     */
    public function getKapasitas(Bidang $bidang, ?int $pembimbingId = null): int
    {
        if ($pembimbingId) {
            $pembimbing = $bidang->pembimbings()->where('pembimbings.id', $pembimbingId)->first();
            if ($pembimbing) {
                return (int) ($pembimbing->pivot->kuota ?? $pembimbing->kuota_default ?? 5);
            }
            $pembimbingModel = \App\Models\Pembimbing::find($pembimbingId);
            if ($pembimbingModel) {
                return (int) ($pembimbingModel->kuota_default ?? 5);
            }
        }

        return (int) $bidang->kapasitas;
    }

    /**
     * Generate data kalender ketersediaan untuk bulan-bulan tertentu.
     * Mengembalikan array tanggal beserta status 3 warna:
     * - 'jeda_verifikasi' (Abu-abu): Kurang dari 14 hari dari hari pendaftaran
     * - 'penuh' (Merah): Kapasitas kuota pada rentang durasi tersebut sudah penuh
     * - 'tersedia' (Hijau): Sudah melewati 14 hari dan kuota masih tersedia
     *
     * @param  Bidang    $bidang
     * @param  int       $durasiBulan
     * @param  int       $bulanKedepan
     * @param  int|null  $pembimbingId
     * @return array
     */
    public function getKalenderTersedia(Bidang $bidang, int $durasiBulan, int $bulanKedepan = 4, ?int $pembimbingId = null): array
    {
        $hasil = [];
        $today = Carbon::today();
        $kapasitas = $this->getKapasitas($bidang, $pembimbingId);

        // Awal dari bulan saat ini s/d $bulanKedepan bulan ke depan
        $tanggal = $today->copy()->startOfMonth();
        $akhir = $today->copy()->addMonths($bulanKedepan)->endOfMonth();
        $batasVerifikasi = $today->copy()->addDays(14);

        while ($tanggal->lte($akhir)) {
            $tanggalStr = $tanggal->toDateString();

            if ($tanggal->lt($today)) {
                // Hari lampau
                $hasil[$tanggalStr] = [
                    'tipe' => 'lampau',
                    'tersedia' => false,
                    'alasan' => 'Tanggal sudah lewat',
                    'terisi' => 0,
                    'kapasitas' => $kapasitas,
                    'slot_sisa' => 0,
                ];
            } elseif ($tanggal->lt($batasVerifikasi)) {
                // Masa Jeda Verifikasi 14 Hari (Abu-Abu)
                $hasil[$tanggalStr] = [
                    'tipe' => 'jeda_verifikasi',
                    'tersedia' => false,
                    'alasan' => 'Masa jeda verifikasi berkas & administrasi (14 hari kerja)',
                    'terisi' => 0,
                    'kapasitas' => $kapasitas,
                    'slot_sisa' => 0,
                ];
            } else {
                // Tanggal >= Hari Ini + 14 Hari -> Cek Overlap Kuota
                $terisi = $this->hitungSlotTerisi($bidang->id, $tanggalStr, $durasiBulan, $pembimbingId);
                $isTersedia = $terisi < $kapasitas;

                $hasil[$tanggalStr] = [
                    'tipe' => $isTersedia ? 'tersedia' : 'penuh',
                    'tersedia' => $isTersedia,
                    'alasan' => $isTersedia ? 'Tersedia untuk dipilih' : 'Slot penuh pada periode ini',
                    'terisi' => $terisi,
                    'kapasitas' => $kapasitas,
                    'slot_sisa' => max(0, $kapasitas - $terisi),
                ];
            }

            $tanggal->addDay();
        }

        return $hasil;
    }

    /**
     * Validasi ulang ketersediaan slot DENGAN lockForUpdate() untuk mencegah race condition.
     * Dipanggil di dalam DB::transaction() pada submit akhir.
     *
     * @param  int       $bidangId
     * @param  string    $tanggalMulai   Format: Y-m-d
     * @param  int       $durasiBulan
     * @param  int|null  $pembimbingId
     * @return bool      true = masih tersedia, false = penuh
     * @throws \Exception
     */
    public function validateUlang(int $bidangId, string $tanggalMulai, int $durasiBulan, ?int $pembimbingId = null): bool
    {
        $bidang = Bidang::lockForUpdate()->findOrFail($bidangId);
        $kapasitas = $this->getKapasitas($bidang, $pembimbingId);

        $tanggalMulaiCarbon = Carbon::parse($tanggalMulai)->startOfDay();
        $today = Carbon::today();

        // Validasi minimal H+14 dari hari pendaftaran
        if ($tanggalMulaiCarbon->lt($today->copy()->addDays(14))) {
            return false;
        }

        $tanggalSelesai = $tanggalMulaiCarbon->copy()->addMonths($durasiBulan)->subDay()->endOfDay();

        $query = Pengajuan::where('bidang_id', $bidangId)
            ->whereIn('status', $this->statusAktif)
            ->where(function ($q) use ($tanggalMulaiCarbon, $tanggalSelesai) {
                $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                  ->where('tanggal_selesai_rencana', '>=', $tanggalMulaiCarbon);
            });

        if ($pembimbingId) {
            $query->where('pembimbing_id', $pembimbingId);
        }

        $terisi = $query->lockForUpdate()->count();

        return $terisi < $kapasitas;
    }
}
