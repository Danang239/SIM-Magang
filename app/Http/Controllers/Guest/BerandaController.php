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
        $bidangsMahasiswa = \App\Models\Bidang::where('is_active', true)->where('kategori', 'Mahasiswa')->with('pembimbings')->get();
        $bidangsSiswa = \App\Models\Bidang::where('is_active', true)->where('kategori', 'Siswa')->with('pembimbings')->get();
        return view('guest.beranda', compact('bidangsMahasiswa', 'bidangsSiswa'));
    }
}
