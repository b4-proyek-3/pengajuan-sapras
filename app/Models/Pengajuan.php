<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'pengajuans'; 

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'ormawa',
        'nama_pengaju',
        'tanggal_peminjaman',
        'tanggal_berakhir',
        'waktu',
        'nama_kegiatan',
        'tempat_peminjaman',
        'dokumen1',
        'dokumen2',
        'dokumen3',
        'dokumen4',
        'dokumen5',
        // Add any additional fields as necessary
    ];
}
