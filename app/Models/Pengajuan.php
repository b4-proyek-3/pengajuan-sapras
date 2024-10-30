<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan'; 
    protected $primaryKey = 'id_pengajuan';
    public $keyType = 'string';
    
    protected $fillable = [
        'id_pengajuan',
        'nim',
        'tanggal_pengajuan',
        'ormawa',
        'nama_pengaju',
        'tanggal_peminjaman',
        'tanggal_berakhir',
        'waktu',
        'nama_kegiatan',
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

    public $timestamps = false;
    
    public function pengaju()
    {
        return $this->belongsTo(Pengaju::class, 'nim', 'nim');
    }

    public function reviewers()
    {
        return $this->belongsToMany(Reviewer::class, 'reviews', 'id_pengajuan', 'id_reviewer');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'id_tempat', 'id_tempat');
    }
}