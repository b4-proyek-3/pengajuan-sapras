<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'gedung' => 'nullable|exists:gedung,id_gedung',
            'daterange' => 'nullable|string|regex:/^\\d{2} \\w{3} \\d{4} - \\d{2} \\w{3} \\d{4}$/',
            'sort' => 'nullable|string|in:nama_ruangan,created_at', // Sorting allowed columns
            'direction' => 'nullable|string|in:asc,desc', // Sorting direction
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('dashboard.index')->withErrors($validator);
        }
    
        // Fetch gedungs
        $gedungs = Gedung::all();
        $selectedGedung = null;
        $ruangans = collect();
    
        if ($request->filled('gedung')) {
            $selectedGedung = Gedung::find($request->gedung);
    
            // Get date range if provided
            $dateRange = $request->daterange;
            $startDate = null;
            $endDate = null;
    
            if ($dateRange) {
                $dates = explode(' - ', $dateRange);
                $startDate = Carbon::createFromFormat('d M Y', trim($dates[0]));
                $endDate = Carbon::createFromFormat('d M Y', trim($dates[1]));
            }
    
            // Query ruangan with availability check
            $ruangans = Ruangan::where('id_gedung', $request->gedung)
            ->when($dateRange, function ($query) use ($startDate, $endDate) {
                return $query->addSelect(['isBooked' => function ($subquery) use ($startDate, $endDate) {
                    $subquery->selectRaw('COUNT(*)')
                        ->from('menggunakan_ruangan')
                        ->whereColumn('menggunakan_ruangan.id_ruangan', 'ruangan.id_ruangan')
                        ->whereExists(function ($query) use ($startDate, $endDate) {
                            $query->selectRaw(1)
                                ->from('pengajuan')
                                ->whereColumn('pengajuan.id_pengajuan', 'menggunakan_ruangan.id_pengajuan')
                                ->where(function ($q) use ($startDate, $endDate) {
                                    $q->whereBetween('pengajuan.tanggal_pinjam', [$startDate, $endDate])
                                      ->orWhereBetween('pengajuan.tanggal_akhir', [$startDate, $endDate])
                                      ->orWhere(function ($query) use ($startDate, $endDate) {
                                          $query->where('pengajuan.tanggal_pinjam', '<=', $startDate)
                                                ->where('pengajuan.tanggal_akhir', '>=', $endDate);
                                      });
                                });
                        });
                }]);
            })
            ->orderBy('id_ruangan', 'asc') // Pastikan menggunakan kolom yang ada
            ->get();        
        }
    
        // Render view with data
        return view('dashboard', compact('gedungs', 'selectedGedung', 'ruangans'));
    }
    
}