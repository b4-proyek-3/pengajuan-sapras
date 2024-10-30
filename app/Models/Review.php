<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews'; // Nama tabel
    protected $fillable = [
        'id_pengajuan',
        'id_reviewer', 
        'review', 
        'status', 
        'tanggal_review',
    ];

    public $incrementing = false;
    public $timestamps = false;
}
