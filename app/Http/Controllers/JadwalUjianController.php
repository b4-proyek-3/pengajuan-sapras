<?php

namespace App\Http\Controllers;

use App\Models\JadwalUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $jadwals = JadwalUjian::all();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_ujian' => 'required|string|max:255',
            'mulai_ujian' => 'required|date',
            'akhir_ujian' => 'required|date|after_or_equal:mulai_ujian',
        ]);

        JadwalUjian::create($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal Ujian berhasil ditambahkan.');
    }

    public function show(JadwalUjian $jadwal)
    {
        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(JadwalUjian $jadwal)
    {
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, JadwalUjian $jadwal)
    {
        $request->validate([
            'tipe_ujian' => 'required|string|max:255',
            'mulai_ujian' => 'required|date',
            'akhir_ujian' => 'required|date|after_or_equal:mulai_ujian',
        ]);

        $jadwal->update($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal Ujian berhasil diperbarui.');
    }

    public function destroy(JadwalUjian $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal Ujian berhasil dihapus.');
    }

    public function getDisabledDates()
    {
        $jadwal = JadwalUjian::select('mulai_ujian', 'akhir_ujian', 'tipe_ujian')->get();
        $disabledDates = [];

        // Ambil tanggal yang tidak bisa dipilih dari database
        foreach ($jadwal as $item) {
            $startDate = date('Y-m-d', strtotime($item->mulai_ujian . ' -7 days'));
            $endDate = date('Y-m-d', strtotime($item->akhir_ujian . ' +7 days'));

            $currentDate = strtotime($startDate);
            while ($currentDate <= strtotime($endDate)) {
                $disabledDates[] = date('Y-m-d', $currentDate);
                $currentDate = strtotime("+1 day", $currentDate);
            }
        }

        // Ambil hari libur nasional dari API
        try {
            $holidayResponse = Http::get("https://api-harilibur.vercel.app/api");
            $holidays = $holidayResponse->json();

            if (is_array($holidays)) {
                foreach ($holidays as $holiday) {
                    $disabledDates[] = $holiday['holiday_date'];
                }
            }
        } catch (\Exception $e) {
            // Jika API gagal, gunakan daftar hari libur default (opsional)
            $disabledDates = array_merge($disabledDates, [
                "2025-01-01", "2025-02-08", "2025-03-31", "2025-04-10", // Contoh hari libur
            ]);
        }

        // Hilangkan duplikat tanggal
        $disabledDates = array_unique($disabledDates);

        return response()->json(array_values($disabledDates));
    }
}
