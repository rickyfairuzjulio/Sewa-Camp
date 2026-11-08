<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketCamping extends Model
{
    use HasFactory;

    protected $table = 'paket_camping';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'nama_paket',
        'slug',
        'deskripsi',
        'harga_harian_normal',
        'harga_harian_paket',
        'hemat_per_hari',
        'gambar',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'harga_harian_normal' => 'decimal:0',
            'harga_harian_paket' => 'decimal:0',
            'hemat_per_hari' => 'decimal:0',
            'is_active' => 'boolean',
        ];
    }

    public function details()
    {
        return $this->hasMany(DetailPaket::class, 'id_paket', 'id_paket');
    }

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'id_paket', 'id_paket');
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && file_exists(public_path('uploads/paket/' . $this->gambar))) {
            return asset('uploads/paket/' . $this->gambar);
        }
        return 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=800&q=80';
    }
}
