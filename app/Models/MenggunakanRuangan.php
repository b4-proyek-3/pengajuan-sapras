<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenggunakanRuangan extends Model
{
    use HasFactory;

    protected $table = 'menggunakan_ruangan';

    protected $fillable = [
        'id_pengajuan',
        'id_ruangan',
        'tanggal_mulai',
        'tanggal_akhir',
        'waktu_mulai',
        'waktu_akhir'
    ];

    protected $primaryKey = ['id_pengajuan', 'id_ruangan'];
    public $incrementing = false;

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

}
