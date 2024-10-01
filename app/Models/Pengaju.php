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
        'nama',
        'email',
        'password',
    ];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'nim', 'nim');
    }
}
