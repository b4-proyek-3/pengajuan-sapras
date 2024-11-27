<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Ormawa;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashboardStatistics()
    {
        $totalPengajuan = Pengajuan::count();
        $totalTempat = Tempat::count();
        $totalUsers = User::count();
        $totalOrmawa = Ormawa::count();
    
        $monthlyStatus = Pengajuan::select(
            DB::raw('EXTRACT(MONTH FROM tanggal_pengajuan) as month'),
            DB::raw('COUNT(CASE WHEN status = \'selesai\' THEN 1 END) as selesai_count'),
            DB::raw('COUNT(CASE WHEN status = \'ditolak\' THEN 1 END) as ditolak_count')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
        return view('dashboard', compact(
            'totalPengajuan', 
            'totalTempat', 
            'totalUsers', 
            'totalOrmawa',
            'monthlyStatus'
        ));
    }
    
    
}