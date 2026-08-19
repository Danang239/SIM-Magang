<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\SkmPertanyaan;
use App\Models\SkmJawaban;
use Illuminate\Http\Request;

class SkmController extends Controller
{
    /**
     * Store a newly created SKM survey response in storage.
     */
    public function store(Request $request, string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if application is finished
        if ($pengajuan->status !== 'Selesai') {
            return back()->with('error', 'Pengisian survei SKM hanya dapat dilakukan setelah program magang dinyatakan selesai.');
        }

        // Check if already filled
        if ($pengajuan->skmJawabans()->exists()) {
            return back()->with('error', 'Anda sudah mengisi survei kepuasan masyarakat untuk program magang ini.');
        }

        // Get list of active questions to validate
        $activeQuestions = SkmPertanyaan::where('is_active', true)->get();

        // Construct validation rules dynamically
        $rules = [
            'status_disabilitas' => ['required', 'string', 'max:255'],
            'saran' => ['nullable', 'string', 'max:1000'],
            'ratings' => ['required', 'array'],
        ];

        foreach ($activeQuestions as $q) {
            $rules["ratings.{$q->id}"] = ['required', 'integer', 'min:1', 'max:5'];
        }

        $validated = $request->validate($rules, [
            'status_disabilitas.required' => 'Status disabilitas wajib dipilih.',
            'ratings.required' => 'Seluruh instrumen pertanyaan rating wajib diisi.',
            'ratings.*.required' => 'Setiap pertanyaan kuesioner wajib diberi nilai rating.',
            'ratings.*.min' => 'Rating minimal adalah 1 bintang.',
            'ratings.*.max' => 'Rating maksimal adalah 5 bintang.',
            'saran.max' => 'Kritik dan saran maksimal 1000 karakter.',
        ]);

        // Save answers
        foreach ($activeQuestions as $q) {
            SkmJawaban::create([
                'pengajuan_id' => $pengajuan->id,
                'skm_pertanyaan_id' => $q->id,
                'rating' => $validated['ratings'][$q->id],
            ]);
        }

        // Save suggestions and disability status in pengajuans table
        $pengajuan->update([
            'skm_saran' => $request->input('saran'),
            'status_disabilitas' => $request->input('status_disabilitas'),
        ]);

        return back()->with('success', 'Terima kasih! Survei kepuasan masyarakat berhasil dikirim.');
    }
}
