<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Pengajuan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

    public function generateQRCode($id_pengajuan)
    {
        $url = "http://127.0.0.1:8000/validasi/{$id_pengajuan}";

        $client = new Client();
        $response = $client->post('https://plbsh.polban.dev/tes/send', [
            'json' => ['url' => $url],
            'verify' => false,
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['url'])) {
            $qr_code_url = $data['url'];
    
            $qr_image = file_get_contents($qr_code_url);

            $qr_image_path = storage_path('app/public/qr_codes/qrcode_' . $id_pengajuan . '.png');
            
            file_put_contents($qr_image_path, $qr_image);
            
            return $qr_image_path;
        }

        return null;
    }
    
    public function generate(string $id_pengajuan)
    {
        try {
            $qr_image_path = $this->generateQRCode($id_pengajuan);

            // Get pengajuan data with all necessary relationships
            $pengajuan = Pengajuan::with([
                'ruangan.gedung',
                'pengaju.user',
                'pengaju.ormawa',
                'reviewers.user'
            ])->findOrFail($id_pengajuan);
            
            // Extract details
            $ruangans = $pengajuan->ruangan;
            $gedung = $ruangans->map(function ($ruangan) {
                return $ruangan->gedung;
            });

            $nama_gedung = $gedung->isEmpty() ? 'Gedung tidak ditemukan' : $gedung->first()->nama_gedung;
            
            // Get ketua pelaksana details
            $ketua_pelaksana = $pengajuan->pengaju->user->name ?? 'Ketua Pelaksana tidak ditemukan';
            $nama_ormawa = $pengajuan->pengaju->ormawa->nama_ormawa ?? 'Ormawa tidak ditemukan';
            
            // Get reviewers
            $sekum_bem = $this->getReviewerNameByRole($pengajuan->reviewers, 'sekum-bem');
            $kli = $this->getReviewerNameByRole($pengajuan->reviewers, 'kli');
            $wd3 = $this->getReviewerNameByRole($pengajuan->reviewers, 'wd-3');

            // Generate validation URL
            $validationUrl = URL::route('validasi.show', ['id_pengajuan' => $id_pengajuan]);

            // Set PDF options
            $pdf = PDF::loadView('dokumen.generate', [
                'id_pengajuan' => $id_pengajuan,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'nama_ketua_pelaksana' => $ketua_pelaksana,
                'nama_ormawa' => $nama_ormawa,
                'nama_gedung' => $nama_gedung,
                'ruangans' => $ruangans,
                'tanggal_mulai' => Carbon::parse($pengajuan->tanggal_pinjam)->isoFormat('D MMMM Y'),
                'tanggal_akhir' => Carbon::parse($pengajuan->tanggal_akhir)->isoFormat('D MMMM Y'),
                'waktu_kegiatan' => Carbon::parse($pengajuan->waktu_pinjam)->format('H:i') . ' WIB',
                'sekum_bem' => $sekum_bem,
                'kli' => $kli,
                'wd3' => $wd3,
                'qr_code_path' => $qr_image_path,
                'validation_url' => $validationUrl // Pass the validation URL to the view
            ]);

            $pdf->setPaper('A4');
            
            // Generate filename
            $filename = 'Surat_Pengajuan_Sapras_' . str_replace(' ', '_', $pengajuan->nama_kegiatan) . '_' . date('Y-m-d') . '.pdf';

            // Return PDF for download
            return $pdf->download($filename);

        } catch (\Exception $e) {
            logger('Error generating PDF: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat dokumen: ' . $e->getMessage());
        }
    }

    private function getReviewerNameByRole($reviewers, $role)
    {
        $reviewer = $reviewers->firstWhere('role', $role);
        return $reviewer ? $reviewer->user->name : 'Tidak ditentukan';
    }
}