<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkmPertanyaan;
use Illuminate\Http\Request;

class SkmPertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pertanyaans = SkmPertanyaan::orderBy('urutan', 'asc')->get();

        return view('admin.skm.index', compact('pertanyaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get next default order sequence
        $nextUrutan = SkmPertanyaan::max('urutan') + 1;

        return view('admin.skm.create', compact('nextUrutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teks_pertanyaan' => ['required', 'string', 'max:1000'],
            'urutan' => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ], [
            'teks_pertanyaan.required' => 'Teks pertanyaan wajib diisi.',
            'urutan.required' => 'Nomor urutan wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'is_active.required' => 'Status keaktifan wajib dipilih.',
        ]);

        SkmPertanyaan::create($request->all());

        return redirect()->route('admin.skm-pertanyaan.index')
            ->with('success', 'Pertanyaan kuesioner SKM berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkmPertanyaan $skmPertanyaan)
    {
        return view('admin.skm.edit', compact('skmPertanyaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkmPertanyaan $skmPertanyaan)
    {
        $request->validate([
            'teks_pertanyaan' => ['required', 'string', 'max:1000'],
            'urutan' => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ], [
            'teks_pertanyaan.required' => 'Teks pertanyaan wajib diisi.',
            'urutan.required' => 'Nomor urutan wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'is_active.required' => 'Status keaktifan wajib dipilih.',
        ]);

        $skmPertanyaan->update($request->all());

        return redirect()->route('admin.skm-pertanyaan.index')
            ->with('success', 'Pertanyaan kuesioner SKM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkmPertanyaan $skmPertanyaan)
    {
        // Safety check: Prevent deletion if answers exist to protect integrity
        if ($skmPertanyaan->skmJawabans()->exists()) {
            return back()->with('error', 'Pertanyaan tidak dapat dihapus karena sudah memiliki data respon jawaban dari peserta. Ubah status menjadi Non-Aktif jika tidak ingin menampilkan pertanyaan ini.');
        }

        $skmPertanyaan->delete();

        return redirect()->route('admin.skm-pertanyaan.index')
            ->with('success', 'Pertanyaan kuesioner SKM berhasil dihapus.');
    }
}
