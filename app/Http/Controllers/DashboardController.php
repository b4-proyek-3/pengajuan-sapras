<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Ormawa;
use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\MenggunakanRuangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::all();
        return view('dashboard', compact('gedungs'));
    }

    public function getCalendarData()
    {
        $menggunakanRuangan = MenggunakanRuangan::with(['ruangan', 'pengajuan.pengaju.ormawa'])->get();

        $events = [];

        foreach ($menggunakanRuangan as $item) {
            $startDate = \Carbon\Carbon::parse($item->tanggal_mulai);
            $endDate = \Carbon\Carbon::parse($item->tanggal_akhir);

            $statusPengajuan = $item->pengajuan->status ?? 'Tidak Diketahui';
            $ormawa = $item->pengajuan->pengaju->ormawa->nama_ormawa ?? 'Tidak Diketahui';

            while ($startDate->lte($endDate)) {
                $events[] = [
                    'id' => $item->id,
                    'id_pengajuan' => $item->id_pengajuan,
                    'id_ruangan' => $item->id_ruangan,
                    'title' => $item->pengajuan->nama_kegiatan . ' (Ruangan: ' . $item->ruangan->nama_ruangan . ')',
                    'start' => $startDate->toDateString() . 'T' . $item->waktu_mulai,
                    'end' => $startDate->toDateString() . 'T' . $item->waktu_akhir,
                    'description' => 'Ruangan: ' . $item->ruangan->nama_ruangan,
                    'status' => $statusPengajuan,
                    'ormawa' => $ormawa,
                    'extendedProps' => [
                        'status' => $statusPengajuan,
                        'ormawa' => $ormawa
                    ]
                ];

                $startDate->addDay(); // Pindah ke hari berikutnya
            }
        }
        return response()->json($events);
    }
}