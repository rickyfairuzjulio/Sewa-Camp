<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiSistem extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_sistem';
    protected $primaryKey = 'id_notif';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe', // info, sukses, peringatan, bahaya
        'link',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
