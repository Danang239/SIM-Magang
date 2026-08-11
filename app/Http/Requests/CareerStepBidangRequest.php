<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerStepBidangRequest extends FormRequest
{
    /**
     * Pastikan hanya Pengguna yang bisa mengajukan.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Pengguna');
    }

    public function rules(): array
    {
        return [
            'jenjang' => ['required', 'in:Siswa,Mahasiswa'],
            'bidang_id' => [
                'required',
                'integer',
                'exists:bidangs,id',
                function ($attribute, $value, $fail) {
                    $bidang = \App\Models\Bidang::where('id', $value)
                        ->where('is_active', true)
                        ->where('jenjang', $this->input('jenjang'))
                        ->where('kategori', session('career_step2.kategori'))
                        ->first();

                    if (!$bidang) {
                        $fail('Bidang yang dipilih tidak aktif atau tidak sesuai jenjang dan kategori.');
                    }
                },
            ],
            'durasi_bulan' => ['required', 'integer', 'in:2,3,6'],
            'keahlian' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenjang.required' => 'Jenjang wajib dipilih.',
            'jenjang.in' => 'Jenjang hanya boleh Siswa atau Mahasiswa.',
            'bidang_id.required' => 'Bidang magang wajib dipilih.',
            'bidang_id.exists' => 'Bidang yang dipilih tidak ditemukan.',
            'durasi_bulan.required' => 'Durasi magang wajib dipilih.',
            'durasi_bulan.in' => 'Durasi hanya boleh 2, 3, atau 6 bulan.',
            'keahlian.required' => 'Keahlian/kompetensi wajib diisi.',
        ];
    }
}
