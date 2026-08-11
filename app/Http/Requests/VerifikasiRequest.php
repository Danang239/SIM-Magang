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
        // Only Petugas or Administrator can verify submissions
        return auth()->check() && auth()->user()->hasAnyRole(['Petugas', 'Administrator']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'action' => ['required', 'string', 'in:setujui,tolak'],
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
            'action.required' => 'Keputusan verifikasi wajib ditentukan.',
            'action.in' => 'Keputusan hanya boleh Setujui atau Tolak.',
            'catatan.required_if' => 'Alasan/catatan penolakan wajib diisi jika Anda menolak pengajuan.',
            'catatan.max' => 'Catatan penolakan maksimal 1000 karakter.',
        ];
    }
}
