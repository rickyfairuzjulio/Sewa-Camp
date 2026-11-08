<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    protected $primaryKey = 'id_promo';

    protected $fillable = [
        'kode_promo',
        'judul',
        'deskripsi',
        'tipe_diskon', // persen, nominal
        'nilai_diskon',
        'minimal_transaksi',
        'maksimal_diskon',
        'kuota_total',
        'kuota_terpakai',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'nilai_diskon' => 'decimal:0',
            'minimal_transaksi' => 'decimal:0',
            'maksimal_diskon' => 'decimal:0',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function isValidForAmount(float $amount): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = Carbon::today();
        if ($this->tanggal_mulai && $today->lt($this->tanggal_mulai)) {
            return false;
        }
        if ($this->tanggal_selesai && $today->gt($this->tanggal_selesai)) {
            return false;
        }

        if ($this->kuota_total > 0 && $this->kuota_terpakai >= $this->kuota_total) {
            return false;
        }

        if ($amount < (float) $this->minimal_transaksi) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if (!$this->isValidForAmount($amount)) {
            return 0;
        }

        if ($this->tipe_diskon === 'persen') {
            $discount = ($amount * (float) $this->nilai_diskon) / 100;
            if ($this->maksimal_diskon > 0 && $discount > (float) $this->maksimal_diskon) {
                return (float) $this->maksimal_diskon;
            }
            return $discount;
        }

        return min($amount, (float) $this->nilai_diskon);
    }
}
