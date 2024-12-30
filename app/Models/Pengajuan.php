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
        'tanggal_pinjam',
        'tanggal_akhir',
        'waktu_pinjam',
        'nama_kegiatan',
        'jenis_kegiatan',
        'link_drive',
        'status',
        'edited',
        'updated_at',
    ];
    
    public $incrementing = false;
    public $timestamps = false;

    public function pengaju()
    {
        return $this->belongsTo(Pengaju::class, 'nim', 'nim');
    }

    public function reviewers()
    {
        return $this->belongsToMany(Reviewer::class, 'reviews', 'id_pengajuan', 'id_reviewer')
                    ->withPivot('status', 'catatan', 'tanggal_review');
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

    public function ruangan()
    {
        return $this->belongsToMany(Ruangan::class, 'menggunakan_ruangan', 'id_pengajuan', 'id_ruangan');
    }

    public function statusHistory()
    {
        return $this->hasMany(Review::class, 'id_pengajuan', 'id_pengajuan');
    }
}