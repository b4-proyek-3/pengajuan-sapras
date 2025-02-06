<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Review;
use App\Models\Reviewer;
use App\Models\User;
use Carbon\Carbon;

class ValidasiController extends Controller
{
    public function show($id_pengajuan)
    {
        // Mengambil data pengajuan berdasarkan id_pengajuan
        $pengajuan = Pengajuan::with('ruangan', 'pengaju.ormawa')->where('id_pengajuan', $id_pengajuan)->first();

        // Mengambil data review terakhir dari reviewer
        $reviews = Review::where('id_pengajuan', $id_pengajuan)
                 ->with('reviewer') // Pastikan model Review punya relasi ke Reviewer
                 ->orderBy('tanggal_review', 'asc') // Urutkan dari yang paling lama
                 ->get();

        // Mengambil nama penandatangan (sekretaris umum, KLI, WD-3)
        $sekum = optional($reviews->where('reviewer.role', 'sekum-bem')->first())->tanggal_review ?? 'Belum Melakukan Review';
        $kli = optional($reviews->where('reviewer.role', 'kli')->first())->tanggal_review ?? 'Belum Melakukan Review';
        $wd3 = optional($reviews->where('reviewer.role', 'wd-3')->first())->tanggal_review ?? 'Belum Melakukan Review';
 
        // Cek status dokumen (aktif/tidak aktif)
        $waktu_mulai = Carbon::parse($pengajuan->tanggal_pinjam . ' ' . $pengajuan->waktu_pengajuan);
        $waktu_akhir = Carbon::parse($pengajuan->tanggal_akhir . ' 23:59:59');
        $status_dokumen = Carbon::now()->between($waktu_mulai, $waktu_akhir) ? 'Aktif' : 'Tidak Aktif';

        // Mengirim data ke view
        return view('pages.validasi', [
            'pengajuan' => $pengajuan,
            'status_dokumen' => $status_dokumen,
            'sekum' => $sekum,
            'kli' => $kli,
            'wd3' => $wd3,
        ]);
    }
}