<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $fillable = [
        'id_pengajuan',
        'id_reviewer', 
        'review', 
        'status', 
        'tanggal_review',
    ];

    protected $primaryKey = ['id_pengajuan', 'id_reviewer'];
    // Disable auto-incrementing since we're using a composite key
    public $incrementing = false;

    // Disable timestamps if not used
    public $timestamps = false;
    protected $keyType = 'string';

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }

    // Relasi dengan model Reviewer
    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class, 'id_reviewer');
    }
}
