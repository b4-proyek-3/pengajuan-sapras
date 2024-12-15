<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ujian';

    protected $fillable = ['tipe_ujian', 'mulai_ujian', 'akhir_ujian'];

    protected $guarded = ['id_ujian'];
}
