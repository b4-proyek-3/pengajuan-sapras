<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    public function pengaju()
    {
        return $this->hasOne(Pengaju::class, 'id_user', 'id_user');
    }

    public function reviewer()
    {
        return $this->hasOne(Reviewer::class, 'id_user', 'id_user');
    }
    
    public function isReviewer()
    {
        return $this->reviewer()->exists();
    }

}
