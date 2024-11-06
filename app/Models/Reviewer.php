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

    public function pengajuan()
    {
        return $this->belongsToMany(Pengajuan::class, 'reviews', 'id_reviewer', 'id_pengajuan')
            ->withPivot('tanggal_review', 'status', 'review');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
