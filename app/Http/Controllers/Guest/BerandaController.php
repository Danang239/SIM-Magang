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
        $bidangsPertanian = \App\Models\Bidang::where('is_active', true)->where('kategori', 'Pertanian')->with('pembimbing')->get();
        $bidangsNonPertanian = \App\Models\Bidang::where('is_active', true)->where('kategori', 'Non Pertanian')->with('pembimbing')->get();
        return view('guest.beranda', compact('bidangsPertanian', 'bidangsNonPertanian'));
    }
}
