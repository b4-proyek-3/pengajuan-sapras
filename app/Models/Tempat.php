<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tempat';
    protected $table = 'tempat';
    protected $fillable =
    [
        'nama_ruangan',
        'nama_gedung',
    ];

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'id_tempat');
    }
}
