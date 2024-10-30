<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reviewer extends Authenticatable
{
    use HasFactory, Notifiable;

    public $keyType = 'string';
    protected $table = 'reviewers';
    protected $primaryKey = 'id_reviewer';

    protected $fillable = [
        'id_reviewer',
        'nama',
        'email',
        'password',
        'id_role',
    ];

    public function reviews()
    {
        return $this->belongsToMany(Pengajuan::class, 'reviews', 'id_reviewer', 'id_pengajuan');
    }
}
