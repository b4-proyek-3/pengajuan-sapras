<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dokumen')->insert([
            [
                'id_pengajuan' => 'P0001',
                'nama_dokumen' => 'Proposal Kegiatan',
                'path' => 'public/assets/file/jadwal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P0001',
                'nama_dokumen' => 'Surat Peminjaman Sarana dan Prasarana',
                'path' => 'public/assets/file/laporan_akhir.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P0001',
                'nama_dokumen' => 'Surat Pernyataan Ketua Ormawa',
                'path' => 'public/assets/file/surat_izin.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P0001',
                'nama_dokumen' => 'Surat Izin Berkegiatan',
                'path' => 'public/assets/file/proposal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P0001',
                'nama_dokumen' => 'Surat Ketersediaan Pembina',
                'path' => 'public/assets/file/sop.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P0001',
                'nama_dokumen' => 'Lampiran Daftar Peserta',
                'path' => 'public/assets/file/surat_ket.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}