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
        $pengajuan = Pengajuan::with('tempat', 'pengaju.ormawa')->where('id_pengajuan', $id_pengajuan)->first();

        // Mengambil data review terakhir dari reviewer
        $reviews = Review::with('reviewer')->where('id_pengajuan', $id_pengajuan)
                        ->orderBy('tanggal_review', 'desc')
                        ->first();

        $sekum = Reviewer::where('id_user', 2)->with('user')->first(); // id_user = 2 untuk sekretaris umum
        $kli = Reviewer::where('id_user', 3)->with('user')->first(); // id_user = 3 untuk KLI
        $wd3 = Reviewer::where('id_user', 4)->with('user')->first(); // id_user = 4 untuk WD-3

        if ($reviews->reviewer->role === 'sekum-bem') {
            $sekum = $sekum->user->name;
            $kli = 'Belum mereview';
            $wd3 = 'Belum mereview';
        } else if ($reviews->reviewer->role === 'kli') {
            $sekum = $sekum->user->name;
            $kli = $kli->user->name;
            $wd3 = 'Belum mereview';
        } else {
            $sekum = $sekum->user->name;
            $kli = $kli->user->name;
            $wd3 = $wd3->user->name;
        }
        // Mengambil nama penandatangan (sekretaris umum, KLI, WD-3)

        // Cek status dokumen (aktif/tidak aktif)
        $waktu_mulai = Carbon::parse($pengajuan->tanggal_pinjam . ' ' . $pengajuan->waktu_pengajuan);
        $waktu_akhir = Carbon::parse($pengajuan->tanggal_akhir . ' 23:59:59');
        $status_dokumen = Carbon::now()->between($waktu_mulai, $waktu_akhir) ? 'Aktif' : 'Tidak Aktif';

        // Mengirim data ke view
        return view('pages.validasi', [
            'pengajuan' => $pengajuan,
            'reviews' => $reviews,
            'status_dokumen' => $status_dokumen,
            'sekum' => $sekum,
            'kli' => $kli,
            'wd3' => $wd3,
        ]);
    }
}
