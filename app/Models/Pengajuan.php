<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    public $keyType = 'string';
    protected $table = 'pengajuan';

    protected $primaryKey = 'id_pengajuan'; // Menggunakan id_pengajuan sebagai primary key

    protected $fillable = [
        'nim',
        'tanggal_pengajuan',
        'tanggal_pinjam',
        'tanggal_akhir',
        'waktu_pengajuan',
        'nama_kegiatan',
        'dokumen',
    ];

    public function pengaju()
    {
        return $this->belongsTo(Pengaju::class, 'nim', 'nim');
    }

    public function reviewers()
    {
        return $this->belongsToMany(Reviewer::class, 'reviews', 'id_pengajuan', 'nip');
    }

}