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
    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_pengajuan',
        'id_ormawa',
        'nim',
        'tanggal_pengajuan',
        'tanggal_pinjam',
        'tanggal_akhir',
        'waktu_pinjam',
        'nama_kegiatan',
        'jenis_kegiatan',
        'link_drive',
        'status', // Menambahkan status
        'edited', // Menambahkan edited
    ];
    
    public $incrementing = false;

    public $timestamps = false;
    public $incrementing = false;

    public function pengaju()
    {
        return $this->belongsTo(Pengaju::class, 'nim', 'nim');
    }

    public function reviewers()
    {
        return $this->belongsToMany(Reviewer::class, 'reviews', 'id_pengajuan', 'id_reviewer')
                    ->withPivot('catatan', 'tanggal_review');
    }

    public function latestReview()
    {
        return $this->hasMany(Review::class, 'id_pengajuan')
                    ->orderBy('tanggal_review', 'desc')
                    ->limit(2);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'id_tempat', 'id_tempat');
    }

    public function statusHistory()
    {
        return $this->hasMany(Review::class, 'id_pengajuan', 'id_pengajuan');
    }
}
