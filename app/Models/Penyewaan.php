<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $table = 'penyewaan';
    protected $primaryKey = 'id_sewa';

    /** Status: menunggu konfirmasi petugas */
    public const STATUS_MENUNGGU = 'Menunggu';

    /** Status: sudah dikonfirmasi, alat sedang dipinjam */
    public const STATUS_BERJALAN = 'Berjalan';

    /** Status: alat sudah dikembalikan */
    public const STATUS_SELESAI = 'Selesai';

    /** Status: penyewaan dibatalkan */
    public const STATUS_DIBATALKAN = 'Dibatalkan';

    protected $fillable = [
        'id_pelanggan',
        'id_petugas',
        'tgl_sewa',
        'tgl_kembali_rencana',
        'tgl_kembali_aktual',
        'status',
        'total_biaya',
    ];

    protected function casts(): array
    {
        return [
            'tgl_sewa' => 'date',
            'tgl_kembali_rencana' => 'date',
            'tgl_kembali_aktual' => 'date',
            'total_biaya' => 'decimal:0',
        ];
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function details()
    {
        return $this->hasMany(DetailPenyewaan::class, 'id_sewa', 'id_sewa');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_sewa', 'id_sewa');
    }

    public function getTotalDibayarAttribute(): float
    {
        if ($this->relationLoaded('pembayaran')) {
            return (float) $this->pembayaran->sum('jumlah_bayar');
        }

        return (float) $this->pembayaran()->sum('jumlah_bayar');
    }

    public function getSisaTagihanAttribute(): float
    {
        return max(0, (float) $this->total_biaya - $this->total_dibayar);
    }

    public function getDurasiHariAttribute(): int
    {
        if (!$this->tgl_sewa || !$this->tgl_kembali_rencana) {
            return 1;
        }
        $start = Carbon::parse($this->tgl_sewa);
        $end = Carbon::parse($this->tgl_kembali_rencana);
        $diff = $start->diffInDays($end);
        return $diff > 0 ? (int) $diff : 1;
    }

    public function getStatusPembayaranAttribute(): string
    {
        $paid = $this->total_dibayar;
        if ($paid >= (float) $this->total_biaya && (float) $this->total_biaya > 0) {
            return 'Lunas';
        }
        if ($paid > 0) {
            return 'Sebagian';
        }
        return 'Belum Bayar';
    }

    /**
     * Membatalkan penyewaan dan mengembalikan stok alat.
     * Hanya boleh dilakukan jika status masih Menunggu atau Berjalan.
     *
     * @throws \RuntimeException jika status sudah Selesai atau Dibatalkan
     */
    public function batalkan(): void
    {
        if (in_array($this->status, [self::STATUS_SELESAI, self::STATUS_DIBATALKAN], true)) {
            throw new \RuntimeException(
                "Penyewaan dengan status '{$this->status}' tidak dapat dibatalkan."
            );
        }

        foreach ($this->details as $detail) {
            $detail->alat()->lockForUpdate()->first();
            $detail->alat->increment('stok', $detail->jumlah);
        }

        $this->status = self::STATUS_DIBATALKAN;
        $this->save();
    }
}
