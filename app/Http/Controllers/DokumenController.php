<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function update(Request $request, $id_pengajuan)
    {
        // Validasi dokumen berdasarkan checkbox yang dipilih
        $validated = $request->validate([
            'dokumen1' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen2' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen3' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen4' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen5' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen6' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen7' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $dokumen_fields = [
            'dokumen1' => 'Proposal',
            'dokumen2' => 'Term of Reference',
            'dokumen3' => 'Surat Peminjaman Sarana Prasarana',
            'dokumen4' => 'Surat Pernyataan Berkegiatan',
            'dokumen5' => 'Surat Pernyataan Ketua Ormawa',
            'dokumen6' => 'Surat Pendampingan Pembina',
            'dokumen7' => 'Lampiran Daftar Peserta',
        ];

        // Pastikan pengajuan valid
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);

        // Perbarui atau simpan dokumen
        foreach ($dokumen_fields as $dokumen => $nama_dokumen) {
            if ($request->hasFile($dokumen)) {
                // Cari dokumen lama jika ada
                $existingDokumen = Dokumen::where('id_pengajuan', $id_pengajuan)
                    ->where('nama_dokumen', $nama_dokumen)
                    ->first();
        
                // Simpan file baru
                $file = $request->file($dokumen);
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('dokumen/' . $id_pengajuan, $filename, 'public');
        
                if ($existingDokumen) {
                    // Hapus file lama tetapi tetap simpan data di database
                    Storage::delete($existingDokumen->path);
        
                    // Update path di database
                    $existingDokumen->update([
                        'path' => $path,
                    ]);
                } else {
                    // Buat entri baru jika dokumen tidak ada
                    Dokumen::create([
                        'id_pengajuan' => $id_pengajuan,
                        'nama_dokumen' => $nama_dokumen,
                        'path' => $path,
                    ]);
                }
            }
        }
        
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui.');
    }
}
