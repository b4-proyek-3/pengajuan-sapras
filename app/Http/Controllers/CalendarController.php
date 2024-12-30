<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function showCalendar(Request $request)
    {
        $ruanganId = $request->input('ruangan_id');
        $ruanganList = Ruangan::all();
        return view('calendar.index', compact('ruanganId', 'ruanganList'));
    }

    public function getCalendarData(Request $request)
    {
        $ruanganId = $request->input('ruangan_id'); 

        $pengajuan = Pengajuan::where('status', 'selesai')
            ->whereHas('ruangan', function ($query) use ($ruanganId) {
                if ($ruanganId) {
                    $query->where('id_ruangan', $ruanganId);
                }
            })
            ->with('ruangan') 
            ->get();

        $events = $pengajuan->map(function ($item) {
            $ruanganNames = $item->ruangan->pluck('nama_ruangan')->join(', ');

            return [
                'title' => $item->nama_kegiatan . ' (Ruangan: ' . $ruanganNames . ')',
                'start' => $item->tanggal_pinjam . 'T' . $item->waktu_pinjam,
                'end' => $item->tanggal_akhir,
                'description' => 'Ruangan yang digunakan: ' . $ruanganNames,
            ];
        });

        return response()->json($events); 
    }
}
