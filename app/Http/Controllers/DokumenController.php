<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\URL;

class DokumenController extends Controller
{
    public function generate(string $id_pengajuan)
    {
        try {
            // Get pengajuan data with all necessary relationships
            $pengajuan = Pengajuan::with([
                'tempat', 
                'pengaju.user', 
                'pengaju.ormawa', 
                'reviewers.user'
            ])->findOrFail($id_pengajuan);
            
            // Extract details
            $tempat = $pengajuan->tempat;
            $nama_gedung = $tempat ? $tempat->nama_gedung : 'Gedung tidak ditemukan';
            $nama_ruangan = $tempat ? $tempat->nama_ruangan : 'Ruangan tidak ditemukan';
            
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
                'nama_ruangan' => $nama_ruangan,
                'tanggal_mulai' => Carbon::parse($pengajuan->tanggal_pinjam)->isoFormat('D MMMM Y'),
                'tanggal_akhir' => Carbon::parse($pengajuan->tanggal_akhir)->isoFormat('D MMMM Y'),
                'waktu_kegiatan' => Carbon::parse($pengajuan->waktu_pinjam)->format('H:i') . ' WIB',
                'sekum_bem' => $sekum_bem,
                'kli' => $kli,
                'wd3' => $wd3,
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