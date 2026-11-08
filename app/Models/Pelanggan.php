<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'user_id',
        'nama',
        'no_hp',
        'alamat',
        'no_identitas',
        'status_verifikasi',
        'jumlah_terlambat',
        'poin_loyalitas',
        'total_transaksi_selesai',
    ];

    /**
     * Relasi ke akun login pelanggan (tabel users).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Cek apakah pelanggan diblokir dan tidak boleh menyewa.
     */
    public function isBlocked(): bool
    {
        return $this->status_verifikasi === 'diblokir';
    }

    /**
     * Hasilkan tautan WhatsApp (https://wa.me/62...) dari nomor HP pelanggan.
     */
    public function whatsappUrl(?string $message = null): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->no_hp);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62'.$digits;
        }

        $url = 'https://wa.me/'.$digits;

        if ($message !== null && $message !== '') {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }
}
