<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class StatusPengajuanController extends Controller
{
    public function index()
    {
        // Fetch all submissions
        $pengajuanRiwayat = Pengajuan::with(['pengaju.ormawa'])->get();

        return view('layout.status', compact('pengajuanRiwayat'));
    }
}
