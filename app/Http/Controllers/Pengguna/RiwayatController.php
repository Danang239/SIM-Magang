<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the user's applications only (data isolation).
     */
    public function index(Request $request)
    {
        $query = Pengajuan::with(['bidang'])
            ->where('user_id', auth()->id()); // HANYA milik pengguna yang sedang login

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by nomor pengajuan or bidang name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhereHas('bidang', fn($b) => $b->where('nama_bidang', 'like', "%{$search}%"));
            });
        }

        // Sort order
        $sort = $request->get('sort', 'desc');
        $query->orderBy('created_at', $sort === 'asc' ? 'asc' : 'desc');

        $pengajuans = $query->paginate(10)->withQueryString();

        return view('pengguna.riwayat.index', compact('pengajuans'));
    }
}
