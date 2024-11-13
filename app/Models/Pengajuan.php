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
        'id_ormawa',
        'nim',
        'tanggal_pengajuan',
        'tanggal_pinjam',
        'tanggal_akhir',
        'waktu_pengajuan',
        'id_tempat',
        'nama_kegiatan',
        'link_gdrive',
        'status',
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

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'id_ormawa', 'id_ormawa');
    }
}