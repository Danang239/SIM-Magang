<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BidangRequest extends FormRequest
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
            'nama_bidang' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'jobdesc' => ['nullable', 'string', 'max:4000'],
            'jenjang' => ['required', 'string', 'in:Siswa,Mahasiswa'],
            'kategori' => ['required', 'string', 'in:Pertanian,Non Pertanian'],
            'pembimbing_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'petugas_ids' => ['nullable', 'array'],
            'petugas_ids.*' => ['integer', 'exists:users,id'],
            'kuota_petugas' => ['nullable', 'array'],
            'kuota_petugas.*' => ['nullable', 'integer', 'min:1', 'max:100'],
            'kapasitas' => ['nullable', 'integer', 'min:1', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_bidang.required' => 'Nama bidang penempatan wajib diisi.',
            'nama_bidang.max' => 'Nama bidang maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi bidang penempatan wajib diisi.',
            'deskripsi.max' => 'Deskripsi bidang maksimal 2000 karakter.',
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
            'jenjang.in' => 'Jenjang pendidikan hanya boleh Siswa atau Mahasiswa.',
            'pembimbing_id.exists' => 'Pembimbing yang dipilih tidak ditemukan.',
            'kapasitas.required' => 'Kapasitas kuota rolling wajib diisi.',
            'kapasitas.integer' => 'Kapasitas kuota harus berupa angka.',
            'kapasitas.min' => 'Kapasitas minimal adalah 1 slot.',
            'kapasitas.max' => 'Kapasitas maksimal adalah 100 slot.',
            'is_active.required' => 'Status bidang wajib ditentukan.',
            'is_active.boolean' => 'Status bidang tidak valid.',
        ];
    }
}
