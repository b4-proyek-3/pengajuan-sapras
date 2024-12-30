<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function showCalendar(Request $request)
    {
        // Mengambil ID ruangan dari parameter jika ada
        $ruanganId = $request->input('ruangan_id');
        $ruanganList = Ruangan::all();
        return view('calendar.index', compact('ruanganId', 'ruanganList'));
    }

    public function getCalendarData(Request $request)
    {
        $ruanganId = $request->input('ruangan_id'); // Mendapatkan ID ruangan dari request

        // Menarik pengajuan yang statusnya selesai dan menggunakan ruangan yang dipilih
        $pengajuan = Pengajuan::where('status', 'selesai')
            ->whereHas('ruangan', function ($query) use ($ruanganId) {
                // Pastikan hanya pengajuan yang menggunakan ruangan yang dipilih yang diambil
                if ($ruanganId) {
                    $query->where('id_ruangan', $ruanganId);
                }
            })
            ->with('ruangan') // Mengambil relasi dengan ruangan
            ->get();

        // Mengubah data pengajuan menjadi format event untuk FullCalendar
        $events = $pengajuan->map(function ($item) {
            // Ambil nama ruangan terkait dengan pengajuan ini
            $ruanganNames = $item->ruangan->pluck('nama_ruangan')->join(', ');

            return [
                'title' => $item->nama_kegiatan . ' (Ruangan: ' . $ruanganNames . ')',
                'start' => $item->tanggal_pinjam . 'T' . $item->waktu_pinjam,
                'end' => $item->tanggal_akhir, // Hanya menampilkan tanggal selesai
                'description' => 'Ruangan yang digunakan: ' . $ruanganNames,
            ];
        });

        return response()->json($events); // Mengembalikan data event dalam format JSON
    }
}
