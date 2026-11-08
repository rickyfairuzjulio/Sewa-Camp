<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    use HasFactory;

    protected $table = 'detail_pengembalian';
    protected $primaryKey = 'id_detail_pengembalian';

    protected $fillable = [
        'id_pengembalian',
        'id_alat',
        'jumlah_sewa',
        'jumlah_kembali_baik',
        'jumlah_rusak',
        'jumlah_hilang',
        'biaya_ganti_rugi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'biaya_ganti_rugi' => 'decimal:0',
        ];
    }

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}
