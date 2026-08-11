<?php

namespace App\Services;

use App\Models\SkmPertanyaan;
use Illuminate\Database\Eloquent\Collection;

class SkmService
{
    /**
     * Ambil semua pertanyaan SKM yang aktif, diurutkan berdasarkan kolom urutan.
     *
     * @return Collection
     */
    public function getPertanyaanAktif(): Collection
    {
        return SkmPertanyaan::where('is_active', true)
            ->orderBy('urutan')
            ->get();
    }

    /**
     * Validasi bahwa semua pertanyaan aktif sudah dijawab.
     *
     * @param  array $jawabanInput  Array dari input form ['skm' => [pertanyaan_id => rating]]
     * @return bool
     */
    public function isLengkap(array $jawabanInput): bool
    {
        $pertanyaanIds = $this->getPertanyaanAktif()->pluck('id')->toArray();
        $dijawab = array_keys($jawabanInput['skm'] ?? []);

        foreach ($pertanyaanIds as $id) {
            if (!in_array($id, array_map('intval', $dijawab))) {
                return false;
            }
        }

        return true;
    }
}
