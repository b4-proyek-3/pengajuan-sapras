<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Ruangan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TempatListController extends Controller
{
    public function index(Request $request)
    {
        $this->validateInput($request);
        $gedungs = Gedung::all();
        $params = $this->getSearchParams($request);
        [$startDate, $endDate] = $this->processDateRange($params['daterange']);

        // Ambil ruangan berdasarkan gedung dan parameter lainnya
        $ruangans = $this->fetchRooms($params['gedung'], $startDate, $endDate, $params['sort']);

        // Proses waktu ruangan yang sudah dibooking
        $bookedTimes = $this->getBookedTimes($ruangans, $startDate, $endDate);
       

        // Kirim data ke view
        return view('tempat_list', [
            'gedungs' => $gedungs,
            'selectedGedung' => $params['gedung'] ? Gedung::find($params['gedung']) : null,
            'ruangans' => $ruangans,
            'bookedTimes' => $bookedTimes,
        ]);
    }

    /**
     * Validasi input request.
     */
    private function validateInput(Request $request)
    {
        Validator::make($request->all(), [
            'gedung' => 'nullable|exists:gedung,id_gedung',
            'daterange' => 'nullable|string',
            'sort' => 'nullable|in:asc,desc',
        ])->validate();
    }

    /**
     * Ambil parameter pencarian dari request atau session.
     */
    private function getSearchParams(Request $request)
    {
        $fromDashboard1 = $request->input('from_dashboard1');
        if ($fromDashboard1) {
            session([
                'search_gedung' => $request->input('gedung'),
                'search_daterange' => $request->input('daterange'),
            ]);
            return redirect()->route('dashboard.index')->withInput();
        }

        return [
            'gedung' => $request->filled('gedung') ? $request->input('gedung') : session('search_gedung'),
            'daterange' => $request->filled('daterange') ? $request->input('daterange') : session('search_daterange'),
            'sort' => $request->input('sort', 'asc'),
        ];
    }

    /**
     * Proses range tanggal dari input daterange.
     */
    private function processDateRange($daterange)
    {
        if (!$daterange) {
            return [null, null];
        }

        try {
            $dates = explode(' - ', $daterange);
            if (count($dates) === 2) {
                $startDate = Carbon::createFromFormat('d M Y', trim($dates[0]));
                $endDate = Carbon::createFromFormat('d M Y', trim($dates[1]));
                return [$startDate->min($endDate), $startDate->max($endDate)];
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Format tanggal tidak valid')
                ->withInput();
        }

        return [null, null];
    }

    /**
     * Ambil data ruangan berdasarkan gedung, tanggal, dan parameter lainnya.
     */
    private function fetchRooms($gedungId, $startDate, $endDate, $sort)
    {
        if (!$gedungId) {
            return collect();
        }

        $query = Ruangan::where('id_gedung', $gedungId)->with(['gedung']);

        if ($startDate && $endDate) {
            $query->with(['menggunakanRuangan' => function ($q) use ($startDate, $endDate) {
                $q->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                        ->orWhereBetween('tanggal_akhir', [$startDate, $endDate])
                        ->orWhere(function ($subQuery) use ($startDate, $endDate) {
                            $subQuery->where('tanggal_mulai', '<=', $startDate)
                                ->where('tanggal_akhir', '>=', $endDate);
                        });
                })->orderBy('tanggal_mulai');
            }]);
        }

        return $query->orderBy('nama_ruangan', $sort)->get();
    }

    /**
     * Proses waktu yang sudah dibooking dari ruangan.
     */
    public function getBookedTimes($ruangans, $startDate, $endDate)
    {
        try {
            if (!$startDate || !$endDate) {
                return collect();
            }

            // Ambil semua tanggal dalam rentang yang dicari
            $dateRange = CarbonPeriod::create($startDate, '1 day', $endDate)->toArray();

            // Mengambil booked times per ruangan
            $bookedTimes = $ruangans->flatMap(function ($ruangan) use ($startDate, $endDate) {
                return $ruangan->menggunakanRuangan->flatMap(function ($booking) use ($startDate, $endDate, $ruangan) {
                    try {
                        // Parsing tanggal dan waktu mulai dan akhir booking
                        $startBooking = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tanggal_mulai . ' ' . $booking->waktu_mulai);
                        $endBooking = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tanggal_akhir . ' ' . $booking->waktu_akhir);

                        // Membuat rentang tanggal yang dibooking
                        $bookedDates = CarbonPeriod::create($startBooking, '1 day', $endBooking);

                        // Filter tanggal berdasarkan rentang yang diminta
                        return collect(iterator_to_array($bookedDates))->filter(function ($date) use ($startDate, $endDate) {
                            return $date->startOfDay()->gte($startDate->startOfDay()) && $date->startOfDay()->lte($endDate->startOfDay());
                        })->map(function ($date) use ($startBooking, $endBooking, $ruangan) {
                            return [
                                'id_ruangan' => $ruangan->id_ruangan,
                                'date' => $date->isoFormat('DD MMMM YYYY'),
                                'start' => $startBooking->format('H:i'),
                                'end' => $endBooking->format('H:i')
                            ];
                        });
                    } catch (\Exception $e) {
                        \Log::error("Error in booking for room {$ruangan->id_ruangan}: {$e->getMessage()}");
                        return collect();
                    }
                });
            })->values();

            // Dapatkan semua tanggal dalam rentang yang dicari, dengan status "Kosong" jika tidak ada booking
            $allDates = collect($dateRange)->map(function ($date) use ($bookedTimes, $ruangans) {
                try {
                    // Ambil ruangan pertama untuk id_ruangan
                    $ruangan = $ruangans->first(); // Ambil ruangan pertama, bisa disesuaikan dengan kebutuhan

                    // Cek apakah tanggal tersebut ada dalam data booking
                    $booked = $bookedTimes->firstWhere('date', $date->isoFormat('DD MMMM YYYY'));

                    // Jika tidak ada booking, kirimkan tanggal dengan status "Kosong"
                    if (!$booked) {
                        return [
                            'id_ruangan' => $ruangan->id_ruangan, // Menggunakan id_ruangan dari ruangan
                            'date' => $date->isoFormat('DD MMMM YYYY'),
                            'status' => 'Kosong' // Menandakan bahwa tanggal tersebut tersedia
                        ];
                    }

                    // Jika ada booking, kirimkan data booking dengan waktu mulai dan akhir
                    return $booked;
                } catch (\Exception $e) {
                    \Log::error("Error processing date {$date->isoFormat('DD MMMM YYYY')}: {$e->getMessage()}");
                    return [
                        'date' => $date->isoFormat('DD MMMM YYYY'),
                        'status' => 'Error' // Status error jika terjadi pengecualian
                    ];
                }
            });

            return $allDates;
        } catch (\Exception $e) {
            \Log::error("Error in getBookedTimes: {$e->getMessage()}");
            return collect(); // Kembalikan koleksi kosong jika terjadi kesalahan umum
        }
    }
}