<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Gedung;
use Illuminate\Http\Request;

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

    public function update(Request $request, $id)
    {
        // Ambil data ruangan yang akan diperbarui
        $ruangan = Ruangan::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $id . ',id_ruangan',
            'id_gedung' => 'required|exists:gedung,id_gedung',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto bersifat opsional
            'kapasitas' => 'required|integer|min:1',
        ]);

        // Proses unggah foto (jika ada)
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($ruangan->foto && \Storage::disk('public')->exists($ruangan->foto)) {
                \Storage::disk('public')->delete($ruangan->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('uploads/ruangan', 'public');
            $validated['foto'] = $fotoPath; // Update path foto di database
        }

        // Update data di database
        $ruangan->update($validated);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
