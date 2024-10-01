<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengajuan;

use App\Http\Controllers\Controller;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        // Logika untuk menyimpan pengajuan
        return response()->json(['message' => 'Pengajuan berhasil dibuat'], 201);
    }
    
    public function index(Request $request)
    {
        // Ambil nilai sorting dari query string
        $sortStatus = $request->input('sort_status');
        $search = $request->input('search');

        // Query dasar untuk mengambil data pengajuan
        $query = Pengajuan::query();

        // Jika ada nilai sorting berdasarkan status, tambahkan sorting
        if ($sortStatus) {
            $query->where('status', $sortStatus);
        }

        // Jika ada pencarian, filter berdasarkan nama kegiatan atau ormawa
        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                ->orWhere('ormawa', 'like', '%' . $search . '%');
        }

        // Dapatkan data pengajuan setelah filter dan sorting
        $pengajuanList = $query->get();

        // Kembalikan view dengan data pengajuan yang sudah difilter dan diurutkan
        return view('pengajuan.index', compact('pengajuanList'));
    }

    public function create()
    {
        return view('pengajuan.form_pengajuan');
    }
    
    public function form(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'ormawa' => 'required|string|max:255',
            'nama_pengaju' => 'required|string|max:255',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'waktu' => 'required',
            'nama_kegiatan' => 'required|string|max:255',
            'tempat_peminjaman' => 'required|string|max:255',
            'dokumen1' => 'required|file|mimes:pdf|max:2048', // Required file
            'dokumen2' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen3' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen4' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen5' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen6' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen7' => 'nullable|file|mimes:pdf|max:2048',
            'link_grive' => 'string|max:255'
        ]);

        // Handle file uploads
        $dokumen1 = $request->file('dokumen1')->store('dokumen', 'public');
        $dokumen2 = $request->file('dokumen2') ? $request->file('dokumen2')->store('dokumen', 'public') : null;
        $dokumen3 = $request->file('dokumen3') ? $request->file('dokumen3')->store('dokumen', 'public') : null;
        $dokumen4 = $request->file('dokumen4') ? $request->file('dokumen4')->store('dokumen', 'public') : null;
        $dokumen5 = $request->file('dokumen5') ? $request->file('dokumen5')->store('dokumen', 'public') : null;
        $dokumen6 = $request->file('dokumen5') ? $request->file('dokumen5')->store('dokumen', 'public') : null;
        $dokumen7 = $request->file('dokumen5') ? $request->file('dokumen5')->store('dokumen', 'public') : null;

        // Save form data and file paths to the database 
        Pengajuan::create([
            'ormawa' => $request->ormawa,
            'nama_pengaju' => $request->nama_pengaju,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'waktu' => $request->waktu,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tempat_peminjaman' => $request->tempat_peminjaman,
            'dokumen1' => $dokumen1,
            'dokumen2' => $dokumen2,
            'dokumen3' => $dokumen3,
            'dokumen4' => $dokumen4,
            'dokumen5' => $dokumen5,
            'dokumen6' => $dokumen5,
            'dokumen7' => $dokumen5,
            'link_gdrive' => $link_gdrive,
        ]);
        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diajukan.');
    }

    public function details()
    {
        //$pengajuan = Pengajuan::findOrFail($id); 

        return view('pengajuan.details'); 
    }

}