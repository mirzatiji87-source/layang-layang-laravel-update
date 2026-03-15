<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'juri_id',
        'design_id',
        'orisinalitas',
        'estetika',
        'budaya',
        'teknis',
        'final_score',
        'catatan',
    ];

    // Relasi ke juri
    public function juri()
    {
        return $this->belongsTo(User::class, 'juri_id');
    }

    // Relasi ke design
    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    // Hitung final score otomatis
    public static function hitungFinal($orisinalitas, $estetika, $budaya, $teknis)
    {
        return ($orisinalitas * 0.30) + ($estetika * 0.25) + ($budaya * 0.25) + ($teknis * 0.20);
    }
}