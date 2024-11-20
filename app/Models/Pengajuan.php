<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    
    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';
    public $timestamps = false;

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'id_tempat');
    }

    public function pengaju()
    {
        return $this->belongsTo(Pengaju::class, 'nim');
    }
}
