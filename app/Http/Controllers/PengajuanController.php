<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\Ormawa;
use App\Models\Dokumen;
use App\Models\Pengaju;
use App\Models\JadwalUjian;
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
        $pengajuans->waktu_pinjam = Carbon::createFromFormat('H:i:s', $pengajuans->waktu_pinjam)->format('H:i');
        return view('pengajuan.detail', compact('pengajuans', 'tempatList'));
    }

    public function create()
    {
        $ormawaList = Ormawa::all();
        $tempatList = Ruangan::all();

        return view('pengajuan.index', compact('ormawaList', 'tempatList'));
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
        $tanggalInput = Carbon::parse($tanggal);
    
        foreach ($jadwalUjian as $ujian) {
            $mulaiUjian = Carbon::parse($ujian->mulai_ujian);
            $akhirUjian = Carbon::parse($ujian->akhir_ujian);
    
            if ($tanggalInput->between($mulaiUjian->subDays(7), $akhirUjian->addDays(7))) {
                session()->flash('alert', "$label tidak boleh berada dalam H-7 hingga H+7 dari tanggal ujian.");
                $fail("$label tidak boleh berada dalam H-7 hingga H+7 dari tanggal ujian.");
            }
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $pengaju = $user->pengaju;
            $existingCount = Pengajuan::count();

            $request->validate([
                'tanggal_pinjam' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $this->validateTanggalUjian($value, $fail, 'Tanggal pinjam');
                }
            ],
            'tanggal_akhir' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $this->validateTanggalUjian($value, $fail, 'Tanggal berakhir');
                }
            ],
                'waktu_pinjam' => 'required',
                'ruangan' => 'required|array|min:1',
                'ruangan.*' => 'exists:ruangan,id_ruangan',
                'nama_kegiatan' => 'required|string|max:100',
                'link_gdrive' => 'nullable|url',
                'activity_type' => 'required|string|in:proker,pergerakan',
                'dokumen1' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen2' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen3' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen4' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen5' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen6' => 'nullable|file|mimes:pdf|max:2048',
                'dokumen7' => 'nullable|file|mimes:pdf|max:2048',
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
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_akhir' => $request->tanggal_akhir,
                'waktu_pinjam' => $request->waktu_pinjam,
                'nama_kegiatan' => $request->nama_kegiatan,
                'jenis_kegiatan' => $request->activity_type,
                'link_drive' => $request->link_gdrive,
                'updated_at' => now(),
            ]);

            $pengajuan->ruangan()->sync($request->ruangan);

            // Simpan setiap dokumen yang diunggah
            $this->simpanDokumen($request, $id_pengajuan);

            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Ketika tabel ujian tidak memiliki data
            return redirect()->route('pengajuan.index')->with('error', 'Gagal menambahkan pengajuan. Data ujian tidak ditemukan.');
        } catch (\Exception $e) {
            // Penanganan general error lainnya
            return redirect()->route('pengajuan.index')->with('error', 'Terjadi kesalahan saat menambahkan pengajuan.');
        }
    }

    private function simpanDokumen(Request $request, $id_pengajuan)
    {
        \Log::info('Memulai proses penyimpanan dokumen.', ['request' => $request->all(), 'id_pengajuan' => $id_pengajuan]);

        $dokumen_fields = [
            'dokumen1' => 'Proposal',
            'dokumen2' => 'Term of Reference',
            'dokumen3' => 'Surat Peminjaman Sarana Prasarana',
            'dokumen4' => 'Surat Pernyataan Berkegiatan',
            'dokumen5' => 'Surat Pernyataan Ketua Ormawa',
            'dokumen6' => 'Surat Pendampingan Pembina',
            'dokumen7' => 'Lampiran Daftar Peserta',
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
    }

    public function update(Request $request, string $id_pengajuan)
    {
        try {
            $validatedData = $request->validate([
                'tanggal_pinjam' => 'nullable|date',
                'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_pinjam',
                'ruangan' => 'required|array|min:1',
                'ruangan.*' => 'exists:ruangan,id_ruangan',
                'nama_kegiatan' => 'nullable|string',
                'nama_tempat' => 'nullable|string',
                'waktu_pengajuan' => 'nullable|date_format:H:i',
            ]);
    
            $pengajuan = Pengajuan::findOrFail($id_pengajuan);
    
            $updateData = array_filter([
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_akhir' => $request->tanggal_akhir,
                'nama_kegiatan' => $request->nama_kegiatan,
                'waktu_pinjam' => $request->waktu_pengajuan,
            ], function ($value) {
                return $value !== null;
            });

            $pengajuan->update($updateData);
            $pengajuan->ruangan()->sync($request->ruangan);

            return redirect()->route('pengajuan.show', $pengajuan->id_pengajuan)->with('success', 'Informasi pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('pengajuan.show', $id_pengajuan)->with('failed', 'Informasi pengajuan tidak berhasil diperbarui.');
        }
    }

    public function submitPengajuan(Request $request, $id_pengajuan)
    {
        // Validasi status yang diterima
        $request->validate([
            'status' => 'required|string',
        ]);

        // Cari pengajuan berdasarkan ID
        $pengajuan = Pengajuan::find($id_pengajuan);

        // Pastikan pengajuan ditemukan
        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
        }

        $pengajuan->edited = true;
        $pengajuan->status = 'diedit';

        // Simpan perubahan ke database
        $pengajuan->save();

        // Kembali ke halaman pengajuan dengan pesan sukses
        return redirect()->route('pengajuan.show', $id_pengajuan)
                        ->with('success', 'Pengajuan berhasil diedit');
    }
}
