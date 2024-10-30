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
        // Data dokumen dummy
        DB::table('dokumen')->insert([
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'Proposal Kegiatan',
                'path' => 'public/assets/file/jadwal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'Laporan Akhir',
                'path' => 'public/assets/file/laporan_akhir.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'Surat Izin',
                'path' => 'public/assets/file/surat_izin.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'Proposal',
                'path' => 'public/assets/file/proposal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'SOP',
                'path' => 'public/assets/file/sop.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'Surat Keterangan',
                'path' => 'public/assets/file/surat_ket.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengajuan' => 'P00011',
                'nama_dokumen' => 'Surat',
                'path' => 'public/assets/file/surat.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
