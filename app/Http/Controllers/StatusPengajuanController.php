<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class StatusPengajuanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cek apakah user adalah pengaju atau reviewer
        if ($user->pengaju) {
            $pengajuanRiwayat = Pengajuan::with(['pengaju.ormawa'])
                ->where('nim', $user->pengaju->nim)
                ->paginate(10);
        } else { // Jika user adalah reviewer
            $pengajuanRiwayat = Pengajuan::with(['pengaju.ormawa'])
                ->paginate(10);
        }

        return view('layout.status', compact('pengajuanRiwayat'));
    }
}
