<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id_review';
    protected $fillable = [
        'id_pengajuan',
        'nip',
        'review',
        'status',
        'tanggal_review',
    ];

    public $timestamps = false;

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class, 'nip', 'nip');
    }
}