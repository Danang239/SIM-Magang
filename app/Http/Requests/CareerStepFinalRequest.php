<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CareerStepFinalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Pengguna');
    }

    public function rules(): array
    {
        return [
            'file_surat_pengantar' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file_surat_pengantar.required' => 'File surat pengantar wajib diunggah.',
            'file_surat_pengantar.file' => 'File surat pengantar tidak valid.',
            'file_surat_pengantar.mimes' => 'Format file hanya boleh PDF, JPG, atau PNG.',
            'file_surat_pengantar.max' => 'Ukuran file maksimal 2MB.',
        ];
    }

    /**
     * Prepare for validation — lakukan MIME sniffing tambahan untuk file upload.
     */
    protected function prepareForValidation(): void
    {
        // Additional MIME sniffing is performed after standard validation in controller
    }
}
