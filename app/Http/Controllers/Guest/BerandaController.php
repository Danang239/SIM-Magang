<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Display the landing page of the application.
     */
    public function index()
    {
        $bidangsMahasiswa = \App\Models\Bidang::where('is_active', true)
            ->where('kategori', 'Mahasiswa')
            ->with('pembimbings')
            ->orderByRaw("FIELD(nama_bidang, 'Biologi molekuler', 'Kultur jaringan', 'Bank Gen Pertanian', 'Hubungan Masyarakat', 'Teknologi Informasi')")
            ->get();

        $bidangsSiswa = \App\Models\Bidang::where('is_active', true)
            ->where('kategori', 'Siswa')
            ->with('pembimbings')
            ->orderByRaw("FIELD(nama_bidang, 'Bank Gen Pertanian', 'Unit Pengelola Benih Sumber (UPBS)', 'Perkantoran')")
            ->get();

        return view('guest.beranda', compact('bidangsMahasiswa', 'bidangsSiswa'));
    }
}
