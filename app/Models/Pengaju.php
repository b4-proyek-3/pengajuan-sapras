<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengaju extends Authenticatable
{
    use HasFactory, Notifiable;

    public $keyType = 'string';
    protected $table = 'pengaju';
    protected $primaryKey = 'nim'; // nim sebagai primary key

    protected $fillable = [
        'nim',
        'id_user',
        'id_ormawa',
    ];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'nim', 'nim');
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'id_ormawa', 'id_ormawa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
