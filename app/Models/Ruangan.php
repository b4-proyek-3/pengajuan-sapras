<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'nama_ruangan',
        'id_gedung',
        'foto',
        'kapasitas'
    ];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function pengajuan()
    {
        return $this->belongsToMany(Pengajuan::class, 'menggunakan_ruangan', 'id_ruangan', 'id_pengajuan');
    }
}
