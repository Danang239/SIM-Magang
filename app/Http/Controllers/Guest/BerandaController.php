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
        $bidangs = \App\Models\Bidang::where('is_active', true)->with('pembimbing')->get();
        return view('guest.beranda', compact('bidangs'));
    }
}
