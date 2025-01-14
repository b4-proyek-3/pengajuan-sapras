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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Dashboard1Controller extends Controller
{
    public function index(Request $request)
    {
        // Validate input with more flexible date format
        $validator = Validator::make($request->all(), [
            'gedung' => 'nullable|exists:gedung,id_gedung',
            'daterange' => 'nullable|string',
            'sort' => 'nullable|in:asc,desc',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Initialize variables
        $gedungs = Gedung::all();
        $selectedGedung = null;
        $ruangans = collect();
        $startDate = null;
        $endDate = null;
        $bookedTimes = collect(); // Initialize $bookedTimes here

        // Process date range if provided
        if ($request->filled('daterange')) {
            try {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) === 2) {
                    $startDate = Carbon::createFromFormat('d M Y', trim($dates[0]));
                    $endDate = Carbon::createFromFormat('d M Y', trim($dates[1]));

                    // Ensure start date is not after end date
                    if ($startDate->gt($endDate)) {
                        $temp = $startDate;
                        $startDate = $endDate;
                        $endDate = $temp;
                    }
                }
            } catch (\Exception $e) {
                return redirect()->route('dashboard.index')
                    ->with('error', 'Format tanggal tidak valid')
                    ->withInput();
            }
        }

        // Fetch rooms if building is selected
        if ($request->filled('gedung')) {
            $selectedGedung = Gedung::find($request->gedung);
            
            $ruangansQuery = Ruangan::where('id_gedung', $request->gedung)
                ->with(['gedung']);

            // Add booking relation with date filtering
            if ($startDate && $endDate) {
                $ruangansQuery->with(['menggunakanRuangan' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                          ->orWhereBetween('tanggal_akhir', [$startDate, $endDate])
                          ->orWhere(function ($inner) use ($startDate, $endDate) {
                              $inner->where('tanggal_mulai', '<=', $startDate)
                                   ->where('tanggal_akhir', '>=', $endDate);
                          });
                    })->orderBy('tanggal_mulai');
                }]);

                // Add isBooked calculation
                $ruangansQuery->addSelect(['isBooked' => function ($query) use ($startDate, $endDate) {
                    $query->selectRaw('COUNT(*) > 0')
                        ->from('menggunakan_ruangan')
                        ->whereColumn('menggunakan_ruangan.id_ruangan', 'ruangan.id_ruangan')
                        ->where(function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                              ->orWhereBetween('tanggal_akhir', [$startDate, $endDate])
                              ->orWhere(function ($inner) use ($startDate, $endDate) {
                                  $inner->where('tanggal_mulai', '<=', $startDate)
                                       ->where('tanggal_akhir', '>=', $endDate);
                              });
                        });
                }]);
            }

            // Apply sorting
            $ruangans = $ruangansQuery
                ->orderBy('nama_ruangan', $request->get('sort', 'asc'))
                ->get();

            // Process booked times
            if ($startDate && $endDate) {
                $bookedTimes = $ruangans->flatMap(function ($ruangan) {
                    return $ruangan->menggunakanRuangan->map(function ($booking) use ($ruangan) {
                        return [
                            'id_ruangan' => $ruangan->id_ruangan,
                            'date' => Carbon::parse($booking->tanggal_mulai)->isoFormat('DD MMMM YYYY'),
                            'start' => $booking->waktu_mulai,
                            'end' => $booking->waktu_akhir,
                        ];
                    });
                })->values();
            }
        }
        
        // Store the search parameters in session when searching
        if ($request->filled('gedung') || $request->filled('daterange')) {
            session([
                'search_gedung' => $request->input('gedung'),
                'search_daterange' => $request->input('daterange'),
            ]);
        }

        return view('dashboard1', compact('gedungs', 'selectedGedung', 'ruangans', 'bookedTimes'));
    }
    
}