<?php

namespace App\Http\Requests;

use App\Services\KuotaService;
use Illuminate\Foundation\Http\FormRequest;

class CareerStepTanggalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Pengguna');
    }

    public function rules(): array
    {
        return [
            'durasi_bulan' => ['required', 'integer', 'in:2,3,4,5,6'],
            'keahlian' => ['required', 'string', 'max:1000'],
            'tanggal_mulai' => [
                'required',
                'date',
                'after:' . \Carbon\Carbon::now()->addDays(13)->toDateString(),
                function ($attribute, $value, $fail) {
                    $bidangId = session('bidang_id') ?? $this->bidang_id;
                    if (!$bidangId) {
                        $fail('Data bidang belum terpilih.');
                        return;
                    }

                    $durasi = (int) $this->durasi_bulan;

                    // Validasi ulang server-side via KuotaService (tidak percaya kalender front-end)
                    $kuotaService = app(KuotaService::class);
                    $terisi = $kuotaService->hitungSlotTerisi(
                        $bidangId,
                        $value,
                        $durasi
                    );

                    $bidang = \App\Models\Bidang::find($bidangId);
                    if ($bidang && $terisi >= $bidang->kapasitas) {
                        $fail('Tanggal yang dipilih sudah penuh. Silakan pilih tanggal lain.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'durasi_bulan.required' => 'Durasi magang wajib dipilih.',
            'durasi_bulan.in' => 'Durasi magang harus antara 2 hingga 6 bulan.',
            'keahlian.required' => 'Keahlian wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai magang wajib dipilih.',
            'tanggal_mulai.date' => 'Format tanggal tidak valid.',
            'tanggal_mulai.after' => 'Tanggal mulai magang minimal harus berjarak 14 hari dari hari ini untuk proses verifikasi.',
        ];
    }
}
