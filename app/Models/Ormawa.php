<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ormawa';
    protected $table = 'ormawa';
    protected $fillable = ['nama_ormawa'];

    public function pengaju() {
        return $this->hasMany(Pengaju::class, 'id_ormawa');
    }
}