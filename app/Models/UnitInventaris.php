<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitInventaris extends Model
{
    use HasFactory;

    protected $table = 'unit_inventaris';
    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'id_alat',
        'kode_unit',
        'kondisi', // Tersedia, Dipesan, Sedang Disewa, Perlu Dibersihkan, Dalam Perawatan, Rusak, Hilang
        'catatan',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }

    public function perawatan()
    {
        return $this->hasMany(PerawatanAlat::class, 'id_unit', 'id_unit');
    }
}
