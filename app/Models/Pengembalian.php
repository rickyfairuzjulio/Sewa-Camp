<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_sewa',
        'id_petugas',
        'tanggal_rencana_kembali',
        'tanggal_aktual_kembali',
        'terlambat_hari',
        'denda_keterlambatan',
        'denda_kerusakan_kehilangan',
        'total_denda',
        'status_denda', // tidak_ada, belum_lunas, lunas
        'kondisi_umum',
        'catatan_pemeriksaan',
        'foto_pemeriksaan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_rencana_kembali' => 'date',
            'tanggal_aktual_kembali' => 'datetime',
            'denda_keterlambatan' => 'decimal:0',
            'denda_kerusakan_kehilangan' => 'decimal:0',
            'total_denda' => 'decimal:0',
        ];
    }

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'id_sewa', 'id_sewa');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function details()
    {
        return $this->hasMany(DetailPengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }
}
