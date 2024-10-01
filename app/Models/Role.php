<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nama_role'];

    public function reviewers() {
        return $this->hasMany(Reviewer::class, 'id_role');
    }
}
