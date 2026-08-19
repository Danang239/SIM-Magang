<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class RiwayatPengajuanController extends Controller
{
    /**
     * Display a listing of all historical applications with filters.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::with(['user', 'bidang']);

        // Filter Bidang
        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->input('bidang_id'));
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter Tanggal Pengajuan (Dari)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->input('tanggal_dari'));
        }

        // Filter Tanggal Pengajuan (Sampai)
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->input('tanggal_sampai'));
        }

        // Search Keyword
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $bidangs = Bidang::orderBy('nama_bidang', 'asc')->get();

        return view('admin.riwayat-pengajuan.index', compact('pengajuans', 'bidangs'));
    }

    /**
     * Display details of a specific application in read-only mode.
     */
    public function show(string $publicId)
    {
        $pengajuan = Pengajuan::where('public_id', $publicId)
            ->with(['user', 'bidang', 'bidang.pembimbing', 'statusLogs', 'statusLogs.user'])
            ->firstOrFail();

        $statusLogs = $pengajuan->statusLogs()->orderBy('created_at', 'asc')->get();

        return view('admin.riwayat-pengajuan.show', compact('pengajuan', 'statusLogs'));
    }
}
