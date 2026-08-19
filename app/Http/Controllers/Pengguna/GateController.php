<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
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
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('error', 'Form SKM hanya dapat diisi jika pengajuan Anda sudah disetujui.');
        }

        // Cek jika sudah pernah mengisi SKM untuk pengajuan ini
        if ($pengajuan->skmJawabans()->exists()) {
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('info', 'Anda sudah mengisi kuesioner SKM.');
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
            return redirect()->route('pengguna.pengajuan.show', $pengajuan->public_id)->with('error', 'Aksi tidak diizinkan.');
        }

        $pertanyaans = $this->skmService->getPertanyaanAktif();
        
        $rules = [
            'status_disabilitas' => ['required', 'string', 'max:255'],
            'skm_saran' => ['nullable', 'string', 'max:2000'],
        ];
        foreach ($pertanyaans as $p) {
            $rules["skm.{$p->id}"] = ['required', 'integer', 'between:1,5'];
        }

        $validated = $request->validate($rules, [
            'status_disabilitas.required' => 'Status disabilitas wajib dipilih.',
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

            // Simpan saran & status disabilitas ke pengajuan
            $pengajuan->update([
                'skm_saran' => $request->skm_saran,
                'status_disabilitas' => $request->status_disabilitas,
            ]);

            // Cek jika gate lengkap, promosikan ke Terjadwal
            if ($pengajuan->isGateCompleted()) {
                $pengajuan->update(['status' => 'Terjadwal']);

                PengajuanStatusLog::create([
                    'pengajuan_id' => $pengajuan->id,
                    'status' => 'Terjadwal',
                    'catatan' => 'Calon peserta telah melengkapi kuesioner SKM. Status otomatis menjadi Terjadwal.',
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
     * Memastikan pemilik pengajuan adalah user yang sedang login.
     */
    protected function authorizeOwner(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk pengajuan ini.');
        }
    }
}
