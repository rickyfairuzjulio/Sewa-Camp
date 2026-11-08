<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Mengubah angka nominal menjadi kalimat terbilang Bahasa Indonesia.
     */
    public static function terbilang(float|int|string $angka): string
    {
        $angka = abs((int) $angka);
        $baca = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $hasil = '';

        if ($angka < 12) {
            $hasil = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $hasil = self::terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $hasil = self::terbilang((int) ($angka / 10)) . ' Puluh ' . self::terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = ' Seratus ' . self::terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = self::terbilang((int) ($angka / 100)) . ' Ratus ' . self::terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = ' Seribu ' . self::terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = self::terbilang((int) ($angka / 1000)) . ' Ribu ' . self::terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = self::terbilang((int) ($angka / 1000000)) . ' Juta ' . self::terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = self::terbilang((int) ($angka / 1000000000)) . ' Miliar ' . self::terbilang((int) fmod($angka, 1000000000));
        } else {
            $hasil = 'Angka terlalu besar';
        }

        return trim(preg_replace('/\s+/', ' ', $hasil));
    }

    /**
     * Mengembalikan nominal terbilang lengkap dengan akhiran Rupiah.
     */
    public static function rupiahTerbilang(float|int|string $angka): string
    {
        $val = (int) $angka;
        if ($val === 0) {
            return 'Nol Rupiah';
        }

        return self::terbilang($val) . ' Rupiah';
    }
}
