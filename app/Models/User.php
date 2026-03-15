<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'region',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    // Relasi ke designs
    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    // Relasi ke scores (sebagai juri)
    public function scores()
    {
        return $this->hasMany(Score::class, 'juri_id');
    }

    // Helper cek role
    public function isPeserta()
    {
        return $this->role === 'peserta';
    }

    public function isJuri()
    {
        return $this->role === 'juri';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}