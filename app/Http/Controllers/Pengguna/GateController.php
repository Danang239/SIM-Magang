<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\PengajuanBiodata;
use App\Models\PengajuanStatusLog;
use App\Models\SkmJawaban;
use App\Services\SkmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GateController extends Controller
{
    public function __construct(
        protected SkmService $skmService
    ) {}

    /**
     * Tampilkan form SKM kuesioner.
     */
    public function showSkm(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        if ($pengajuan->status !== 'Disetujui') {
            return redirect()->route('pengguna.dashboard')->with('error', 'Form SKM hanya dapat diisi jika pengajuan Anda sudah disetujui.');
        }

        // Cek jika sudah pernah mengisi SKM untuk pengajuan ini
        if ($pengajuan->skmJawabans()->exists()) {
            return redirect()->route('pengguna.dashboard')->with('info', 'Anda sudah mengisi kuesioner SKM.');
        }

        $pertanyaans = $this->skmService->getPertanyaanAktif();
        return view('pengguna.gate.skm', compact('pengajuan', 'pertanyaans'));
    }

    /**
     * Simpan kuesioner SKM.
     */
    public function storeSkm(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        if ($pengajuan->status !== 'Disetujui') {
            return redirect()->route('pengguna.dashboard')->with('error', 'Aksi tidak diizinkan.');
        }

        $pertanyaans = $this->skmService->getPertanyaanAktif();
        
        $rules = [
            'skm_saran' => ['nullable', 'string', 'max:2000'],
        ];
        foreach ($pertanyaans as $p) {
            $rules["skm.{$p->id}"] = ['required', 'integer', 'between:1,5'];
        }

        $validated = $request->validate($rules, [
            'skm.*.required' => 'Semua pertanyaan wajib dijawab.',
            'skm.*.between' => 'Penilaian harus berada di skala 1 sampai 5.',
        ]);

        DB::transaction(function () use ($request, $pengajuan, $pertanyaans) {
            // Simpan jawaban SKM
            foreach ($pertanyaans as $pertanyaan) {
                SkmJawaban::create([
                    'pengajuan_id' => $pengajuan->id,
                    'skm_pertanyaan_id' => $pertanyaan->id,
                    'rating' => (int) $request->input("skm.{$pertanyaan->id}"),
                ]);
            }

            // Simpan saran ke pengajuan
            $pengajuan->update([
                'skm_saran' => $request->skm_saran
            ]);

            // Cek jika gate lengkap, promosikan ke Terjadwal
            if ($pengajuan->isGateCompleted()) {
                $pengajuan->update(['status' => 'Terjadwal']);

                PengajuanStatusLog::create([
                    'pengajuan_id' => $pengajuan->id,
                    'status' => 'Terjadwal',
                    'catatan' => 'Calon peserta telah melengkapi kuesioner SKM dan Biodata. Status otomatis menjadi Terjadwal.',
                    'created_by' => auth()->id(),
                ]);

                \App\Models\Notifikasi::create([
                    'user_id' => $pengajuan->user_id,
                    'judul' => 'Pengajuan Terjadwal',
                    'pesan' => "Selamat! Pengajuan magang Anda ({$pengajuan->nomor_pengajuan}) kini berstatus Terjadwal. Silakan persiapkan diri Anda.",
                ]);
            }
        });

        return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('success', 'Kuesioner SKM berhasil disimpan.');
    }

    /**
     * Tampilkan form Biodata.
     */
    public function showBiodata(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        if ($pengajuan->status !== 'Disetujui') {
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('error', 'Formulir biodata hanya dapat diisi jika pengajuan Anda sudah disetujui.');
        }

        // SKM must be completed first
        if (!$pengajuan->skmJawabans()->exists()) {
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('error', 'Anda wajib mengisi kuesioner SKM terlebih dahulu sebelum mengisi formulir biodata.');
        }

        // Cek jika sudah pernah mengisi biodata
        if ($pengajuan->biodata()->exists()) {
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('info', 'Anda sudah melengkapi formulir biodata.');
        }

        return view('pengguna.gate.biodata', compact('pengajuan'));
    }

    /**
     * Simpan formulir Biodata.
     */
    public function storeBiodata(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        if ($pengajuan->status !== 'Disetujui') {
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('error', 'Aksi tidak diizinkan.');
        }

        // SKM must be completed first
        if (!$pengajuan->skmJawabans()->exists()) {
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('error', 'Anda wajib mengisi kuesioner SKM terlebih dahulu sebelum mengisi formulir biodata.');
        }

        $validated = $request->validate([
            'nim_nisn' => ['required', 'string', 'max:50'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'alamat' => ['required', 'string', 'max:1000'],
            'kontak_darurat_nama' => ['required', 'string', 'max:255'],
            'kontak_darurat_no' => ['required', 'string', 'max:20'],
            'hubungan_kontak_darurat' => ['required', 'string', 'max:100'],
        ], [
            'nim_nisn.required' => 'NIM / NISN wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'alamat.required' => 'Alamat domisili wajib diisi.',
            'kontak_darurat_nama.required' => 'Nama kontak darurat wajib diisi.',
            'kontak_darurat_no.required' => 'Nomor HP kontak darurat wajib diisi.',
            'hubungan_kontak_darurat.required' => 'Hubungan kontak darurat wajib diisi.',
        ]);

        DB::transaction(function () use ($validated, $pengajuan) {
            PengajuanBiodata::create(array_merge($validated, [
                'pengajuan_id' => $pengajuan->id
            ]));

            // Cek jika gate lengkap, promosikan ke Terjadwal
            if ($pengajuan->isGateCompleted()) {
                $pengajuan->update(['status' => 'Terjadwal']);

                PengajuanStatusLog::create([
                    'pengajuan_id' => $pengajuan->id,
                    'status' => 'Terjadwal',
                    'catatan' => 'Calon peserta telah melengkapi kuesioner SKM dan Biodata. Status otomatis menjadi Terjadwal.',
                    'created_by' => auth()->id(),
                ]);

                \App\Models\Notifikasi::create([
                    'user_id' => $pengajuan->user_id,
                    'judul' => 'Pengajuan Terjadwal',
                    'pesan' => "Selamat! Pengajuan magang Anda ({$pengajuan->nomor_pengajuan}) kini berstatus Terjadwal. Silakan persiapkan diri Anda.",
                ]);
            }
        });

        return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('success', 'Formulir biodata berhasil disimpan.');
    }

    /**
     * Memastikan pemilik pengajuan adalah user yang sedang login.
     */
    protected function authorizeOwner(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk pengajuan ini.');
        }
    }
}
