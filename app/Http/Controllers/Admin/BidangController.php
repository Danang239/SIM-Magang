<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BidangRequest;
use App\Models\Bidang;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bidang::with('pembimbings');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_bidang', 'like', '%' . $search . '%');
        }

        $bidangs = $query->orderBy('nama_bidang', 'asc')->paginate(10)->withQueryString();

        return view('admin.bidang.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pembimbings = Pembimbing::where('is_active', true)->orderBy('nama', 'asc')->get();

        return view('admin.bidang.create', compact('pembimbings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BidangRequest $request)
    {
        $data = $request->validated();
        
        $pembimbingIds = $request->input('pembimbing_ids', []);
        $kuotaPembimbing = $request->input('kuota_pembimbing', []);

        $totalKuota = 0;
        $syncData = [];

        foreach ($pembimbingIds as $pId) {
            $k = isset($kuotaPembimbing[$pId]) ? max(1, (int) $kuotaPembimbing[$pId]) : 5;
            $syncData[$pId] = ['kuota' => $k];
            $totalKuota += $k;
        }

        $data['kapasitas'] = $totalKuota > 0 ? $totalKuota : ($data['kapasitas'] ?? 5);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('bidang', 'public');
        }

        $bidang = Bidang::create($data);

        if (!empty($syncData)) {
            $bidang->pembimbings()->sync($syncData);
        }

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang penempatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        $bidang->load('pembimbings');
        $pembimbings = Pembimbing::where('is_active', true)->orderBy('nama', 'asc')->get();

        return view('admin.bidang.edit', compact('bidang', 'pembimbings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BidangRequest $request, Bidang $bidang)
    {
        $data = $request->validated();

        $pembimbingIds = $request->input('pembimbing_ids', []);
        $kuotaPembimbing = $request->input('kuota_pembimbing', []);

        $totalKuota = 0;
        $syncData = [];

        foreach ($pembimbingIds as $pId) {
            $k = isset($kuotaPembimbing[$pId]) ? max(1, (int) $kuotaPembimbing[$pId]) : 5;
            $syncData[$pId] = ['kuota' => $k];
            $totalKuota += $k;
        }

        $data['kapasitas'] = $totalKuota > 0 ? $totalKuota : ($data['kapasitas'] ?? $bidang->kapasitas);

        if ($request->hasFile('gambar')) {
            if ($bidang->gambar && Storage::disk('public')->exists($bidang->gambar)) {
                Storage::disk('public')->delete($bidang->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('bidang', 'public');
        }

        $bidang->update($data);
        $bidang->pembimbings()->sync($syncData);

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang penempatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        if ($bidang->pengajuans()->exists()) {
            return back()->with('error', 'Bidang tidak dapat dihapus karena sudah digunakan dalam riwayat pengajuan PKL.');
        }

        $bidang->pembimbings()->detach();
        $bidang->delete();

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang penempatan berhasil dihapus.');
    }
}
