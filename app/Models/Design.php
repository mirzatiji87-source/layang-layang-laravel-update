<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'status',
    ];

    // Relasi ke user (peserta)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke scores
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    // Hitung nilai akhir rata-rata
    public function finalScore()
    {
        return $this->scores->avg('final_score');
    }
}