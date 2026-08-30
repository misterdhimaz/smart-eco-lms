<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClimateStat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik iklim
        $climateStats = ClimateStat::all();

        // Ambil data user (dummy: ambil user pertama) beserta progress modulnya
        $user = User::with('progress.module')->first();

        // Kirim data ke view 'dashboard'
        return view('dashboard', compact('climateStats', 'user'));
    }
}
