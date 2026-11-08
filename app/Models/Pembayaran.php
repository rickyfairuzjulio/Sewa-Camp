<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_bayar';

    protected $fillable = [
        'id_sewa',
        'tgl_bayar',
        'jumlah_bayar',
        'metode',
    ];

    protected function casts(): array
    {
        return [
            'tgl_bayar' => 'date',
            'jumlah_bayar' => 'decimal:0',
        ];
    }

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'id_sewa', 'id_sewa');
    }
}
