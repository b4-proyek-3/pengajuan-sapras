<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class StatusPengajuanController extends Controller
{
    public function index()
    {
        $pengaju = auth()->user()->pengaju;
        $pengajuanRiwayat = Pengajuan::with(['pengaju.ormawa'])
            ->where('nim', $pengaju->nim)
            ->paginate(10);

        return view('layout.status', compact('pengajuanRiwayat'));
    }
}
