<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    protected $primaryKey = 'id_alat';

    protected $fillable = [
        'id_kategori',
        'nama_alat',
        'harga_sewa_per_hari',
        'stok',
        'kondisi',
        'deskripsi',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAlat::class, 'id_kategori', 'id_kategori');
    }

    public function detailPenyewaan()
    {
        return $this->hasMany(DetailPenyewaan::class, 'id_alat', 'id_alat');
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && (file_exists(public_path('uploads/alat/'.$this->gambar)) || file_exists('/tmp/uploads/alat/'.$this->gambar))) {
            return asset('uploads/alat/'.$this->gambar);
        }

        $presetByFile = [
            'tenda_dome_2p.jpg' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=800&q=80',
            'tenda_dome_4p.jpg' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?auto=format&fit=crop&w=800&q=80',
            'carrier_60l.jpg' => 'https://images.unsplash.com/photo-1622260614153-03223fb72052?auto=format&fit=crop&w=800&q=80',
            'carrier_45l.jpg' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
            'sleeping_bag.jpg' => 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=800&q=80',
            'matras_foil.jpg' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?auto=format&fit=crop&w=800&q=80',
            'kompor_portable.jpg' => 'https://images.unsplash.com/photo-1526491109672-74740652b963?auto=format&fit=crop&w=800&q=80',
            'nesting_set.jpg' => 'https://images.unsplash.com/photo-1517824806704-9040b037703b?auto=format&fit=crop&w=800&q=80',
            'headlamp_led.jpg' => 'https://images.unsplash.com/photo-1508873696983-2dfd5898f08b?auto=format&fit=crop&w=800&q=80',
            'lampu_tenda.jpg' => 'https://images.unsplash.com/photo-1532339142463-fd0a8979791a?auto=format&fit=crop&w=800&q=80',
        ];

        if ($this->gambar && isset($presetByFile[$this->gambar])) {
            return $presetByFile[$this->gambar];
        }

        $nama = strtolower((string) $this->nama_alat);
        if (str_contains($nama, 'tenda') && str_contains($nama, '4')) {
            return $presetByFile['tenda_dome_4p.jpg'];
        }
        if (str_contains($nama, 'tenda')) {
            return $presetByFile['tenda_dome_2p.jpg'];
        }
        if (str_contains($nama, 'carrier') || str_contains($nama, 'tas')) {
            return str_contains($nama, '60') ? $presetByFile['carrier_60l.jpg'] : $presetByFile['carrier_45l.jpg'];
        }
        if (str_contains($nama, 'sleeping')) {
            return $presetByFile['sleeping_bag.jpg'];
        }
        if (str_contains($nama, 'matras')) {
            return $presetByFile['matras_foil.jpg'];
        }
        if (str_contains($nama, 'kompor')) {
            return $presetByFile['kompor_portable.jpg'];
        }
        if (str_contains($nama, 'nesting') || str_contains($nama, 'masak')) {
            return $presetByFile['nesting_set.jpg'];
        }
        if (str_contains($nama, 'headlamp') || str_contains($nama, 'senter')) {
            return $presetByFile['headlamp_led.jpg'];
        }
        if (str_contains($nama, 'lampu') || str_contains($nama, 'lentera')) {
            return $presetByFile['lampu_tenda.jpg'];
        }

        return asset('images/default-camp.svg');
    }
}
