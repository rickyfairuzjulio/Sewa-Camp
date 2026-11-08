<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'nama_petugas',
        'no_hp',
        'username',
    ];

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'id_petugas', 'id_petugas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'email');
    }
}
