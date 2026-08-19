<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\BidangRequest;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bidang::with(['pembimbing', 'petugasList']);

        // Search by nama_bidang
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_bidang', 'like', '%' . $search . '%');
        }

        $bidangs = $query->orderBy('nama_bidang', 'asc')->paginate(10)->withQueryString();

        return view('petugas.bidang.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all users who can be pembimbing (Petugas or Administrator roles)
        $pembimbings = User::role(['Petugas', 'Administrator'])->orderBy('name', 'asc')->get();

        return view('petugas.bidang.create', compact('pembimbings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BidangRequest $request)
    {
        $data = $request->validated();
        
        $petugasIds = $request->input('petugas_ids', []);
        $kuotaPetugas = $request->input('kuota_petugas', []);

        // Calculate total capacity from assigned petugas quotas if available
        $totalKuota = 0;
        $syncData = [];

        foreach ($petugasIds as $pId) {
            $k = isset($kuotaPetugas[$pId]) ? max(1, (int) $kuotaPetugas[$pId]) : 5;
            $syncData[$pId] = ['kuota' => $k];
            $totalKuota += $k;
        }

        $data['kapasitas'] = $totalKuota > 0 ? $totalKuota : ($data['kapasitas'] ?? 5);

        $bidang = Bidang::create($data);

        if (!empty($syncData)) {
            $bidang->petugasList()->sync($syncData);
        }

        return redirect()->route('petugas.bidang.index')
            ->with('success', 'Bidang penempatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        $bidang->load('petugasList');
        $pembimbings = User::role(['Petugas', 'Administrator'])->orderBy('name', 'asc')->get();

        return view('petugas.bidang.edit', compact('bidang', 'pembimbings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BidangRequest $request, Bidang $bidang)
    {
        $data = $request->validated();

        $petugasIds = $request->input('petugas_ids', []);
        $kuotaPetugas = $request->input('kuota_petugas', []);

        $totalKuota = 0;
        $syncData = [];

        foreach ($petugasIds as $pId) {
            $k = isset($kuotaPetugas[$pId]) ? max(1, (int) $kuotaPetugas[$pId]) : 5;
            $syncData[$pId] = ['kuota' => $k];
            $totalKuota += $k;
        }

        $data['kapasitas'] = $totalKuota > 0 ? $totalKuota : ($data['kapasitas'] ?? $bidang->kapasitas);

        $bidang->update($data);
        $bidang->petugasList()->sync($syncData);

        return redirect()->route('petugas.bidang.index')
            ->with('success', 'Bidang penempatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        // Check if there are associated applications (prevent deletion error)
        if ($bidang->pengajuans()->exists()) {
            return back()->with('error', 'Bidang tidak dapat dihapus karena sudah digunakan dalam pengajuan magang/PKL.');
        }

        $bidang->delete();

        return redirect()->route('petugas.bidang.index')
            ->with('success', 'Bidang penempatan berhasil dihapus.');
    }
}
