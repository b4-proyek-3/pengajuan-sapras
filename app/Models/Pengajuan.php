<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'pengajuan'; 
    protected $primaryKey = 'id_pengajuan';
    public $keyType = 'string';

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'id_pengajuan',
        'tanggal_pengajuan',
        'ormawa',
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
        'dokumen6',
        'dokumen7',
        'link_gdrive',
    ];

    public $incrementing = false;
}
