<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    protected $table = 'tempat';
    protected $fillable = ['nama_tempat'];

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'id_tempat');
    }
}
