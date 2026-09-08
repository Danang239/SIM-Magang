<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pembimbing;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    /**
     * Display a listing of pembimbing.
     */
    public function index(Request $request)
    {
        $query = Pembimbing::with('bidangs')->withCount('pengajuans');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $pembimbings = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view('admin.pembimbing.index', compact('pembimbings'));
    }

    /**
     * Show the form for creating a new pembimbing.
     */
    public function create()
    {
        $bidangs = Bidang::where('is_active', true)->orderBy('nama_bidang')->get();
        return view('admin.pembimbing.create', compact('bidangs'));
    }

    /**
     * Store a newly created pembimbing in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'kuota_default' => ['required', 'integer', 'min:1', 'max:50'],
            'is_active' => ['boolean'],
            'bidang_ids' => ['nullable', 'array'],
            'bidang_ids.*' => ['exists:bidangs,id'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pembimbing = Pembimbing::create($validated);

        if (!empty($validated['bidang_ids'])) {
            $syncData = [];
            foreach ($validated['bidang_ids'] as $bidangId) {
                $syncData[$bidangId] = ['kuota' => $pembimbing->kuota_default];
            }
            $pembimbing->bidangs()->sync($syncData);
        }

        return redirect()->route('admin.pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified pembimbing.
     */
    public function edit(Pembimbing $pembimbing)
    {
        $pembimbing->load('bidangs');
        $bidangs = Bidang::where('is_active', true)->orderBy('nama_bidang')->get();

        return view('admin.pembimbing.edit', compact('pembimbing', 'bidangs'));
    }

    /**
     * Update the specified pembimbing in storage.
     */
    public function update(Request $request, Pembimbing $pembimbing)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'kuota_default' => ['required', 'integer', 'min:1', 'max:50'],
            'is_active' => ['boolean'],
            'bidang_ids' => ['nullable', 'array'],
            'bidang_ids.*' => ['exists:bidangs,id'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pembimbing->update($validated);

        $syncData = [];
        if (!empty($validated['bidang_ids'])) {
            foreach ($validated['bidang_ids'] as $bidangId) {
                // Pertahankan kuota per bidang jika sudah ada, atau gunakan default
                $existing = $pembimbing->bidangs()->where('bidang_id', $bidangId)->first();
                $kuota = $existing ? ($existing->pivot->kuota ?? $pembimbing->kuota_default) : $pembimbing->kuota_default;
                $syncData[$bidangId] = ['kuota' => $kuota];
            }
        }
        $pembimbing->bidangs()->sync($syncData);

        return redirect()->route('admin.pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil diperbarui.');
    }

    /**
     * Remove the specified pembimbing from storage.
     */
    public function destroy(Pembimbing $pembimbing)
    {
        // Cek apakah memiliki pengajuan aktif
        if ($pembimbing->pengajuans()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus pembimbing yang sudah terhubung dengan riwayat pengajuan. Anda dapat menonaktifkannya.');
        }

        $pembimbing->bidangs()->detach();
        $pembimbing->delete();

        return redirect()->route('admin.pembimbing.index')
            ->with('success', 'Pembimbing berhasil dihapus.');
    }
}
