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
    protected $primaryKey = 'nip';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'password',
    ];

    public function reviews()
    {
        return $this->belongsToMany(Pengajuan::class, 'reviews', 'nip', 'id_pengajuan');
    }
}
