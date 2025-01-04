<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Ormawa;
use App\Models\Ruangan;
use App\Models\Gedung;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashboardStatistics()
    {
        $totalPengajuan = Pengajuan::count();
        $totalRuangan = Ruangan::count();
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
            'totalRuangan', 
            'totalUsers', 
            'totalOrmawa',
            'monthlyStatus'
        ));
    }
    
    public function index(Request $request)
    {
        $namaGedung = $request->input('namaGedung');
        $namaRuangan = $request->input('namaRuangan');
        $tanggal = $request->input('tanggal');
        
        // Query pencarian
        $ruanganList = Ruangan::with('gedung')
            ->when($namaGedung, function ($query, $namaGedung) {
                $query->whereHas('gedung', function ($q) use ($namaGedung) {
                    $q->where('nama_gedung', 'like', '%' . $namaGedung . '%');
                });
            })
            ->when($namaRuangan, function ($query, $namaRuangan) {
                $query->where('nama_ruangan', 'like', '%' . $namaRuangan . '%');
            })
            ->when($tanggal, function ($query, $tanggal) {
                // Assuming tanggal is a range "YYYY-MM-DD - YYYY-MM-DD"
                [$startDate, $endDate] = explode(' - ', $tanggal);
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get();

        return view('dashboard', [
            'ruanganList' => $ruanganList,
            'namaGedung' => $namaGedung,
            'namaRuangan' => $namaRuangan,
            'tanggal' => $tanggal,
        ]);
    }    
}