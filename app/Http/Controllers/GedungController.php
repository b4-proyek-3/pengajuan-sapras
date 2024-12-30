<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gedung' => 'required|string|max:255|unique:gedung',
        ]);

        $gedung = Gedung::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'gedung' => $gedung]);
        }

        return redirect()->route('ruangan.index')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function update(Request $request, Gedung $gedung)
    {
        $validated = $request->validate([
            'nama_gedung' => 'required|string|max:255|unique:gedung,nama_gedung,' . $gedung->id_gedung . ',id_gedung',
        ]);

        $gedung->update($validated);
        return redirect()->route('ruangan.index')->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();
        return redirect()->route('ruangan.index')->with('success', 'Gedung berhasil dihapus.');
    }
}
