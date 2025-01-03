<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashboardStatistics()
    {
        // Fetch room data (assumed from the "Tempat" model)
        $rooms = Tempat::select('id', 'nama_tempat', 'status')
            ->where('lokasi', 'Gedung H') // Example filter; you can customize it
            ->get();

        // Pass the data to the view
        return view('dashboard', compact('rooms'));
    }
}
