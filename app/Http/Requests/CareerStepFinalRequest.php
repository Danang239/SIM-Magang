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
            'foto_diri' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'nik_ktp' => ['required', 'string', 'max:30'],
            'no_hp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'instansi' => ['required', 'string', 'max:255'],
            'program_studi' => ['required', 'string', 'max:255'],
            'nim_nisn' => ['required', 'string', 'max:50'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'alamat' => ['required', 'string', 'max:1000'],
            'nama_pimpinan_instansi' => ['required', 'string', 'max:255'],
            'alamat_instansi' => ['required', 'string', 'max:1000'],
            'kontak_instansi' => ['required', 'string', 'max:255'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'tahun_masuk' => ['required', 'string', 'max:10'],
            'pendidikan_terakhir' => ['required', 'string', 'max:100'],
            'semester_saat_ini' => ['required', 'string', 'max:50'],
            'judul_magang' => ['required', 'string', 'max:255'],
            'tujuan_magang' => ['required', 'string', 'max:1000'],
            'nama_dosen_pembimbing' => ['required', 'string', 'max:255'],
            'pembimbing_id' => ['nullable', 'integer', 'exists:users,id'],
            'tanda_tangan_digital' => ['required', 'string'],
            'kontak_darurat_nama' => ['required', 'string', 'max:100'],
            'kontak_darurat_no' => ['required', 'string', 'max:20'],
            'hubungan_kontak_darurat' => ['required', 'string', 'max:50'],
            'file_surat_pengantar' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
            'syarat_ketentuan' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'foto_diri.required' => 'Foto pas 4x6 berwarna wajib diunggah.',
            'foto_diri.mimes' => 'Format foto pas harus berupa JPG, JPEG, atau PNG.',
            'foto_diri.max' => 'Ukuran file foto maksimal 2MB.',
            'nik_ktp.required' => 'No. KTP/NIK wajib diisi.',
            'no_hp.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.min' => 'Nomor HP minimal 10 digit.',
            'no_hp.max' => 'Nomor HP maksimal 15 digit.',
            'instansi.required' => 'Nama Perguruan Tinggi / Sekolah wajib diisi.',
            'program_studi.required' => 'Jurusan / Program Studi wajib diisi.',
            'nim_nisn.required' => 'NIM / NISN wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'nama_pimpinan_instansi.required' => 'Nama Rektor / Kepala Sekolah / Pimpinan wajib diisi.',
            'alamat_instansi.required' => 'Alamat Perguruan Tinggi / Sekolah wajib diisi.',
            'kontak_instansi.required' => 'Kontak Telepon/Email Perguruan Tinggi / Sekolah wajib diisi.',
            'tahun_masuk.required' => 'Tahun Masuk wajib diisi.',
            'pendidikan_terakhir.required' => 'Pendidikan Terakhir wajib diisi.',
            'semester_saat_ini.required' => 'Semester saat ini / Tahun wajib diisi.',
            'judul_magang.required' => 'Judul Magang/PKL wajib diisi.',
            'tujuan_magang.required' => 'Tujuan Magang/PKL wajib diisi.',
            'nama_dosen_pembimbing.required' => 'Nama Dosen / Guru Pembimbing wajib diisi.',
            'tanda_tangan_digital.required' => 'Tanda tangan digital wajib digambar pada kanvas.',
            'kontak_darurat_nama.required' => 'Nama kontak darurat wajib diisi.',
            'kontak_darurat_no.required' => 'Nomor kontak darurat wajib diisi.',
            'hubungan_kontak_darurat.required' => 'Hubungan kontak darurat wajib diisi.',
            'file_surat_pengantar.required' => 'File surat pengantar wajib diunggah.',
            'file_surat_pengantar.file' => 'File surat pengantar tidak valid.',
            'file_surat_pengantar.mimes' => 'Format file hanya boleh PDF, JPG, atau PNG.',
            'file_surat_pengantar.max' => 'Ukuran file maksimal 2MB.',
            'syarat_ketentuan.required' => 'Anda harus menyetujui syarat & ketentuan surat pernyataan.',
            'syarat_ketentuan.accepted' => 'Anda harus menyetujui syarat & ketentuan surat pernyataan.',
        ];
    }
}
