<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Administrator');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'action' => 'required|string|in:setujui,tolak',
            'catatan' => 'required_if:action,tolak|nullable|string|max:1000',
            'file_surat_balasan' => 'required_if:action,setujui|nullable|file|mimes:pdf|max:5120',
            'pembimbing_id' => 'nullable|integer|exists:pembimbings,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Keputusan verifikasi wajib ditentukan.',
            'action.in' => 'Keputusan hanya boleh Setujui atau Tolak.',
            'catatan.required_if' => 'Alasan/catatan penolakan wajib diisi jika Anda menolak pengajuan.',
            'catatan.max' => 'Catatan penolakan maksimal 1000 karakter.',
            'file_surat_balasan.required_if' => 'Surat balasan wajib diunggah dalam format PDF saat menyetujui pengajuan.',
            'file_surat_balasan.file' => 'File surat balasan tidak valid.',
            'file_surat_balasan.mimes' => 'Surat balasan harus berformat PDF.',
            'file_surat_balasan.max' => 'Ukuran file surat balasan maksimal 5MB.',
        ];
    }
}
