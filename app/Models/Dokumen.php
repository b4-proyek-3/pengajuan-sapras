<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen'; 
    protected $primaryKey = 'no_dokumen';

    protected $fillable = [
        'id_pengajuan',
        'nama_dokumen',
        'path'
    ];

    /**
     * Relasi many-to-one ke tabel pengajuan.
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }
}