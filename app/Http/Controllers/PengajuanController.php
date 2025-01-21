<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\Ormawa;
use App\Models\Dokumen;
use App\Models\Pengaju;
use App\Models\JadwalUjian;
use App\Models\MenggunakanRuangan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $pengaju = auth()->user()->pengaju;

        $activeTab = $request->input('active_tab', 'diajukan');

        $pengajuanDiajukan = Pengajuan::whereIn('status', ['diajukan', 'direview', 'direvisi', 'diedit'])
            ->where('nim', $pengaju->nim)
            ->when($request->input('diajukan_sort_status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                      ->orWhereHas('pengaju.ormawa', function($subQuery) use ($search) {
                          $subQuery->where('nama_ormawa', 'like', "%{$search}%");
                      });
                });
            })
            ->paginate(10, ['*'], 'diajukan_page');
    
        $pengajuanRiwayat = Pengajuan::whereIn('status', ['selesai', 'ditolak'])
            ->where('nim', $pengaju->nim)
            ->when($request->input('riwayat_sort_status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                      ->orWhereHas('pengaju.ormawa', function($subQuery) use ($search) {
                          $subQuery->where('nama_ormawa', 'like', "%{$search}%");
                      });
                });
            })
            ->paginate(10, ['*'], 'riwayat_page');
    
        $tempatList = Ruangan::all();
    
        return view('pengajuan.index', compact('pengajuanDiajukan', 'pengajuanRiwayat', 'tempatList', 'activeTab'));
    }

    public function show(string $id_pengajuan)
    {
        $pengajuans = Pengajuan::with(['pengaju', 'reviewers', 'latestReview', 'dokumen', 'ruangan'])->findOrFail($id_pengajuan);
        $tempatList = Ruangan::all();
        return view('pengajuan.detail', compact('pengajuans', 'tempatList'));
    }

    public function create()
    {
        $ormawaList = Ormawa::all();
        $tempatList = Ruangan::all();
        $selectedRuangan = [];

        if ($pengajuan) {
            $selectedRuangan = $pengajuan->ruangan->pluck('id_ruangan')->toArray();
        }

        return view('pengajuan.index', compact('ormawaList', 'tempatList', 'selectedRuangan'));
    }

    public function destroy($id_pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);

        try {
            $pengajuan->delete();
            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pengajuan.index')->with('error', 'Pengajuan gagal dihapus.');
        }
    }

    private function validateTanggalUjian($tanggal, $fail, $label)
    {
        $jadwalUjian = JadwalUjian::all();
    
        // Jika $tanggal adalah array, iterasi setiap itemnya
        $tanggalList = is_array($tanggal) ? $tanggal : [$tanggal];
    
        foreach ($tanggalList as $tanggalItem) {
            $tanggalInput = Carbon::parse($tanggalItem);
    
            foreach ($jadwalUjian as $ujian) {
                $mulaiUjian = Carbon::parse($ujian->mulai_ujian);
                $akhirUjian = Carbon::parse($ujian->akhir_ujian);
    
                if ($tanggalInput->between($mulaiUjian->subDays(7), $akhirUjian->addDays(7))) {
                    session()->flash('alert', "$label tidak boleh berada dalam H-7 hingga H+7 dari tanggal ujian.");
                    $fail("$label tidak boleh berada dalam H-7 hingga H+7 dari tanggal ujian.");
                    return; // Hentikan validasi jika ada konflik
                }
            }
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $pengaju = $user->pengaju;
    
            $request->validate([
                'tanggal_mulai' => [
                    'required',
                    'array',
                    'min:1',
                    function ($attribute, $value, $fail) {
                        $this->validateTanggalUjian($value, $fail, 'Tanggal mulai');
                    }
                ],
                'tanggal_akhir' => [
                    'required',
                    'array',
                    'min:1',
                    function ($attribute, $value, $fail) {
                        $this->validateTanggalUjian($value, $fail, 'Tanggal akhir');
                    }
                ],
                'tanggal_mulai.*' => 'required|date',
                'tanggal_akhir.*' => 'required|date|after_or_equal:tanggal_mulai.*',
                'waktu_mulai' => 'required|array|min:1',
                'waktu_akhir' => 'required|array|min:1',
                'waktu_mulai.*' => 'required|date_format:H:i',
                'waktu_akhir.*' => 'required|date_format:H:i|after:waktu_mulai.*',
                'ruangan' => 'required|array|min:1',
                'ruangan.*' => 'exists:ruangan,id_ruangan',
                'nama_kegiatan' => 'required|string|max:100',
                'nama_ketuplak' => 'required|string|max:50',
                'notelp' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
                'jumlah_peserta' => 'required|integer',
                'link_gdrive' => 'nullable|url',
                'activity_type' => 'required|string|in:proker,pergerakan,latihan_rutin',
                'dokumen1' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen2' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen3' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen4' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen5' => 'nullable|file|mimes:pdf|max:2048',
            ]);
    
            // Membuat ID pengajuan unik
            $lastPengajuan = Pengajuan::orderBy('id_pengajuan', 'desc')->first();
            $lastId = $lastPengajuan ? (int) substr($lastPengajuan->id_pengajuan, 1) : 0;
            $id_pengajuan = 'P' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    
            // Menyimpan data pengajuan
            $pengajuan = Pengajuan::create([
                'id_pengajuan' => $id_pengajuan,
                'nim' => $pengaju->nim,
                'tanggal_pengajuan' => now(),
                'nama_kegiatan' => $request->nama_kegiatan,
                'nama_ketuplak' => $request->nama_ketuplak,
                'notelp' => $request->notelp,
                'jumlah_peserta' => $request->jumlah_peserta,
                'jenis_kegiatan' => $request->activity_type,
                'link_drive' => $request->link_gdrive,
                'status' => 'diajukan',
                'edited' => false,
                'updated_at' => now(),
            ]);

            foreach ($request->ruangan as $index => $ruanganId) {
                try {
                    $tanggalMulai = $request->tanggal_mulai[$index];
                    $tanggalAkhir = $request->tanggal_akhir[$index];
                    $waktuMulai = $request->waktu_mulai[$index];
                    $waktuAkhir = $request->waktu_akhir[$index];
            
                    MenggunakanRuangan::create([
                        'id_pengajuan' => $id_pengajuan,
                        'id_ruangan' => $ruanganId,
                        'tanggal_mulai' => $tanggalMulai,
                        'tanggal_akhir' => $tanggalAkhir,
                        'waktu_mulai' => $waktuMulai,
                        'waktu_akhir' => $waktuAkhir,
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage()); // Menampilkan error jika ada
                }
            }

            // Menyimpan dokumen terkait
            $this->simpanDokumen($request, $id_pengajuan);

            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('pengajuan.index')->with('error', 'Terjadi kesalahan saat menambahkan pengajuan: ' . $e->getMessage());
        }
    }
    
    private function simpanDokumen(Request $request, $id_pengajuan)
    {
        \Log::info('Memulai proses penyimpanan dokumen.', ['request' => $request->all(), 'id_pengajuan' => $id_pengajuan]);
       
        try {
            $dokumen_fields = [
                'dokumen1' => 'Proposal',
                'dokumen2' => 'Term of Reference',
                'dokumen3' => 'Surat Peminjaman Sarana Prasarana',
                'dokumen4' => 'Lembar Pengesahan Kegiatan',
                'dokumen5' => 'Lampiran Daftar Peserta',
            ];
    
            foreach ($dokumen_fields as $field => $nama_dokumen) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('dokumen/' . $id_pengajuan, $filename, 'public');
    
                    Dokumen::create([
                        'id_pengajuan' => $id_pengajuan,
                        'nama_dokumen' => $nama_dokumen,
                        'path' => $path,
                    ]);
    
                    \Log::info("Dokumen $nama_dokumen berhasil disimpan.", ['id_pengajuan' => $id_pengajuan, 'nama_dokumen' => $nama_dokumen, 'path' => $path]);
    
                } else {
                    \Log::warning("Dokumen $field tidak ada dalam permintaan.");
                    
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('pengajuan.index')->with('error', 'Terjadi kesalahan saat menambahkan pengajuan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id_pengajuan)
    {
        try {
            $pengajuan = Pengajuan::findOrFail($id_pengajuan);

            $request->validate([
                'nama_kegiatan' => 'sometimes|string|max:100',
                'nama_ketuplak' => 'sometimes|string|max:50',
                'notelp' => 'sometimes|string|regex:/^\+?[0-9]{10,15}$/',
                'jumlah_peserta' => 'sometimes|integer',
                'tanggal_mulai' => 'sometimes|array|min:1',
                'tanggal_akhir' => 'sometimes|array|min:1',
                'tanggal_mulai.*' => 'required_with:tanggal_akhir.*|date',
                'tanggal_akhir.*' => 'required_with:tanggal_mulai.*|date|after_or_equal:tanggal_mulai.*',
                'waktu_mulai' => 'sometimes|array|min:1',
                'waktu_akhir' => 'sometimes|array|min:1',
                'waktu_mulai.*' => 'required_with:waktu_akhir.*|date_format:H:i',
                'waktu_akhir.*' => 'required_with:waktu_mulai.*|date_format:H:i|after:waktu_mulai.*',
                'ruangan' => 'sometimes|array|min:1',
                'ruangan.*' => 'exists:ruangan,id_ruangan',
            ]);

            // Mengupdate data pengajuan
            $pengajuan->update([
                'nama_kegiatan' => $request->nama_kegiatan ?? $pengajuan->nama_kegiatan,
                'nama_ketuplak' => $request->nama_ketuplak ?? $pengajuan->nama_ketuplak,
                'notelp' => $request->notelp ?? $pengajuan->notelp,
                'jumlah_peserta' => $request->jumlah_peserta ?? $pengajuan->jumlah_peserta,
                'updated_at' => now(),
            ]);

            // Mengupdate data ruangan jika ada
            if ($request->has('ruangan')) {
                MenggunakanRuangan::where('id_pengajuan', $id_pengajuan)->delete();

                foreach ($request->ruangan as $index => $ruanganId) {
                    $tanggalMulai = $request->tanggal_mulai[$index] ?? null;
                    $tanggalAkhir = $request->tanggal_akhir[$index] ?? null;
                    $waktuMulai = $request->waktu_mulai[$index] ?? null;
                    $waktuAkhir = $request->waktu_akhir[$index] ?? null;

                    MenggunakanRuangan::create([
                        'id_pengajuan' => $id_pengajuan,
                        'id_ruangan' => $ruanganId,
                        'tanggal_mulai' => $tanggalMulai,
                        'tanggal_akhir' => $tanggalAkhir,
                        'waktu_mulai' => $waktuMulai,
                        'waktu_akhir' => $waktuAkhir,
                    ]);
                }
            }

            return redirect()->route('pengajuan.show', $pengajuan->id_pengajuan)->with('success', 'Informasi pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('pengajuan.show', $id_pengajuan)->with('failed', 'Informasi pengajuan tidak berhasil diperbarui.');
        }
    }

    public function submitPengajuan(Request $request, $id_pengajuan)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $pengajuan = Pengajuan::find($id_pengajuan);

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
        }

        $pengajuan->edited = true;
        $pengajuan->status = 'diedit';
        $pengajuan->save();

        return redirect()->route('pengajuan.show', $id_pengajuan)->with('success', 'Pengajuan berhasil diedit');
    }
}
