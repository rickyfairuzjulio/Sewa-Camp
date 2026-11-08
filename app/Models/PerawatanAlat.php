<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatanAlat extends Model
{
    use HasFactory;

    protected $table = 'perawatan_alat';
    protected $primaryKey = 'id_perawatan';

    protected $fillable = [
        'id_alat',
        'id_unit',
        'tanggal_masuk',
        'tanggal_selesai',
        'jenis_perawatan',
        'biaya',
        'keterangan',
        'status', // proses, selesai
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
            'tanggal_selesai' => 'date',
            'biaya' => 'decimal:0',
        ];
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }

    public function unit()
    {
        return $this->belongsTo(UnitInventaris::class, 'id_unit', 'id_unit');
    }
}
