<?php

namespace App\Http\Requests;

use App\Services\SkmService;
use Illuminate\Foundation\Http\FormRequest;

class CareerStepFinalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Pengguna');
    }

    public function rules(): array
    {
        // Build SKM rules dynamically based on active questions
        $skmService = app(SkmService::class);
        $pertanyaans = $skmService->getPertanyaanAktif();

        $rules = [
            'skm_saran' => ['nullable', 'string', 'max:2000'],
            'file_surat_pengantar' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
        ];

        // Dynamically add rules for each active SKM question
        foreach ($pertanyaans as $pertanyaan) {
            $rules["skm.{$pertanyaan->id}"] = ['required', 'integer', 'between:1,5'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'file_surat_pengantar.required' => 'File surat pengantar wajib diunggah.',
            'file_surat_pengantar.file' => 'File surat pengantar tidak valid.',
            'file_surat_pengantar.mimes' => 'Format file hanya boleh PDF, JPG, atau PNG.',
            'file_surat_pengantar.max' => 'Ukuran file maksimal 2MB.',
            'skm.*.required' => 'Semua pertanyaan kepuasan harus dijawab.',
            'skm.*.integer' => 'Jawaban kepuasan harus berupa angka.',
            'skm.*.between' => 'Nilai kepuasan antara 1 sampai 5.',
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
