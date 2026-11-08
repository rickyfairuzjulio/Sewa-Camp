<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin, petugas, pelanggan
        'no_hp',
        'avatar',
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
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id', 'id');
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id', 'id');
    }

    public function notifikasi()
    {
        return $this->hasMany(NotifikasiSistem::class, 'user_id', 'id');
    }

    public function unreadNotifikasiCount(): int
    {
        return $this->notifikasi()->where('is_read', false)->count();
    }
}
