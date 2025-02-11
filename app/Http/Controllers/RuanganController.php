<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\MenggunakanRuangan;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Response;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->input('active_tab', 'ruangan');
        $ruangan = Ruangan::with('gedung')->paginate(10, ['*'], 'ruangan_page');
        $gedung = Gedung::paginate(10, ['*'], 'gedung_page');
        $tempatList = Ruangan::with('gedung')->get();
        return view('ruangan.index', compact('ruangan', 'gedung', 'tempatList', 'activeTab'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan',
            'id_gedung' => 'required|exists:gedung,id_gedung',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kapasitas' => 'required|integer|min:1',
        ]);

        // Proses unggah foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/ruangan', 'public');
            $validated['foto'] = $fotoPath; // Simpan path foto ke database
        }

        // Simpan data ke database
        Ruangan::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return response()->json($ruangan);
    }

    public function update(Request $request, $id_ruangan)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $id_ruangan . ',id_ruangan',
            'id_gedung' => 'required|exists:gedung,id_gedung',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $ruangan = Ruangan::findOrFail($id_ruangan);

        // Perbarui data ruangan
        if ($request->hasFile('foto')) {
            if ($ruangan->foto && \Storage::exists('public/' . $ruangan->foto)) {
                \Storage::delete('public/' . $ruangan->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('uploads/ruangan', 'public');
            $validated['foto'] = $fotoPath;
        }

        $ruangan->update($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }

    public function disabledDates(Request $request)
    {
        $id_ruangan = $request->id_ruangan;
        $today = now()->toDateString(); // Ambil tanggal hari ini dalam format 'Y-m-d'
    
        // Ambil semua pemakaian ruangan dari hari ini ke depan
        $data = MenggunakanRuangan::where('id_ruangan', $id_ruangan)
            ->where('tanggal_akhir', '>=', $today) // Pastikan tanggal_akhir masih termasuk hari ini
            ->whereHas('pengajuan', function ($query) {
                $query->where('status', 'selesai');
            })
            ->get(['tanggal_mulai', 'tanggal_akhir', 'waktu_mulai', 'waktu_akhir']);
    
        $disabledDates = [];
        $disabledTimes = [];
    
        foreach ($data as $entry) {
            $start = new DateTime($entry->tanggal_mulai);
            $end = new DateTime($entry->tanggal_akhir);
    
            while ($start <= $end) {
                $formattedDate = $start->format('Y-m-d');
    
                // Hanya tambahkan jika tanggal >= hari ini
                if ($formattedDate >= $today) {
                    $dayOfWeek = $start->format('N'); // 1 = Senin, ..., 7 = Minggu
                    $fullDayHours = ($dayOfWeek >= 6) ? 9.5 : 12.5; // Weekend = 7.5 jam, Weekday = 12.5 jam
    
                    $disabledTimes[$formattedDate][] = [
                        'mulai' => $entry->waktu_mulai,
                        'akhir' => $entry->waktu_akhir
                    ];
                }
                $start->modify('+1 day');
            }
        }
    
        // Cek apakah semua jam di satu hari sudah penuh
        foreach ($disabledTimes as $date => $times) {
            $dayOfWeek = (new DateTime($date))->format('N'); // 1 = Senin, ..., 7 = Minggu
            $fullDayHours = ($dayOfWeek >= 6) ? 9.5 : 12.5; // Weekend = 7.5 jam, Weekday = 12.5 jam
    
            $totalBlockedHours = 0;
            foreach ($times as $time) {
                $startHour = (float) date('H.i', strtotime($time['mulai']));
                $endHour = (float) date('H.i', strtotime($time['akhir']));
                $totalBlockedHours += ($endHour - $startHour);
            }
    
            // Jika semua jam dalam sehari sudah terpakai, masukkan ke disabledDates
            if ($totalBlockedHours >= $fullDayHours) {
                $disabledDates[] = $date;
            }
        }
    
        return Response::json([
            'disabledDates' => array_values(array_unique($disabledDates)), // Tanggal yang penuh
            'disabledTimes' => $disabledTimes // Waktu yang sebagian terpakai
        ]);
    }    
}
