<?php
// app/Models/Review.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    // Remove primary key since we're using composite key
    public $incrementing = false;
    protected $fillable = [
        'id_pengajuan',
        'id_reviewer',
        'status',
        'catatan',
        'tanggal_review',
    ];

    // Disable timestamps since we don't have them in migration
    public $timestamps = false;

    // Define the composite primary key
    protected $primaryKey = ['id_pengajuan', 'id_reviewer'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class, 'id_reviewer', 'id_reviewer');
    }
}