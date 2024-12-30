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
        'id_user',
        'role',
    ];

    public function pengajuan()
    {
        return $this->belongsToMany(Pengajuan::class, 'reviews', 'id_reviewer', 'id_pengajuan')
            ->withPivot('tanggal_review', 'catatan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function scopeOrderedByRole($query)
    {
        return $query->orderByRaw("
        CASE 
            WHEN role = 'sekum-bem' THEN 1
            WHEN role = 'kli' THEN 2
            WHEN role = 'wd-3' THEN 3
            ELSE 4 
        END");
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function getRoleNameAttribute()
    {
        return match ($this->role) {
            'kli' => 'KLI',
            'sekum-bem' => 'BEM',
            'wd-3' => 'WD3',
            default => $this->role,
        };
    }

}
