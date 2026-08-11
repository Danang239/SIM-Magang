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
            'tanggal_mulai' => [
                'required',
                'date',
                'after:today',
                function ($attribute, $value, $fail) {
                    $session = session('career_step3');
                    if (!$session || !isset($session['bidang_id'], $session['durasi_bulan'])) {
                        $fail('Data bidang belum tersedia. Silakan ulangi dari Step 3.');
                        return;
                    }

                    // Validasi ulang server-side via KuotaService (tidak percaya kalender front-end)
                    $kuotaService = app(KuotaService::class);
                    $tersedia = $kuotaService->hitungSlotTerisi(
                        $session['bidang_id'],
                        $value,
                        $session['durasi_bulan']
                    );

                    $bidang = \App\Models\Bidang::find($session['bidang_id']);
                    if ($bidang && $tersedia >= $bidang->kapasitas) {
                        $fail('Tanggal yang dipilih sudah penuh. Silakan pilih tanggal lain.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_mulai.required' => 'Tanggal mulai magang wajib dipilih.',
            'tanggal_mulai.date' => 'Format tanggal tidak valid.',
            'tanggal_mulai.after' => 'Tanggal mulai harus setelah hari ini.',
        ];
    }
}
