<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPaket extends Model
{
    use HasFactory;

    protected $table = 'detail_paket';
    protected $primaryKey = 'id_detail_paket';

    protected $fillable = [
        'id_paket',
        'id_alat',
        'jumlah',
    ];

    public function paket()
    {
        return $this->belongsTo(PaketCamping::class, 'id_paket', 'id_paket');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}
