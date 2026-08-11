<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewLaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Petugas', 'Administrator']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'action' => ['required', 'string', 'in:terima,tolak'],
            'file_surat_keterangan' => [
                'required_if:action,terima',
                'nullable',
                'file',
                'mimes:pdf',
                'max:2048',
            ],
            'catatan' => [
                'required_if:action,tolak',
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Keputusan ulasan laporan wajib ditentukan.',
            'action.in' => 'Keputusan ulasan hanya boleh Terima atau Tolak.',
            'file_surat_keterangan.required_if' => 'Berkas Surat Keterangan Selesai Magang (PDF) wajib diunggah jika laporan diterima.',
            'file_surat_keterangan.mimes' => 'Format file surat keterangan harus berupa PDF.',
            'file_surat_keterangan.max' => 'Ukuran file surat keterangan maksimal 2MB.',
            'catatan.required_if' => 'Catatan revisi wajib diisi jika laporan ditolak.',
            'catatan.max' => 'Catatan revisi maksimal 1000 karakter.',
        ];
    }
}
