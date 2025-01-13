<?php

namespace App\Http\Controllers;

use App\Models\JadwalUjian;
use Illuminate\Http\Request;

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
}
