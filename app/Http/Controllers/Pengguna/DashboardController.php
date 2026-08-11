<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Pengguna dashboard.
     */
    public function index()
    {
        return redirect()->route('home');
    }
}
