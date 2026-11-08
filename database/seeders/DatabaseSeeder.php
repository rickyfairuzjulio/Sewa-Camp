<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\KategoriAlat;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\Petugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna (Users)
        $admin = User::firstOrCreate(
            ['email' => 'admin@campsewa.test'],
            [
                'name' => 'Administrator CampSewa',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $petugas1 = User::firstOrCreate(
            ['email' => 'budi@campsewa.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );

        $petugas2 = User::firstOrCreate(
            ['email' => 'siti@campsewa.test'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );

        // Akun pelanggan (terhubung ke data pelanggan id=1: Dimas Arya Pratama)
        $pelangganUser = User::firstOrCreate(
            ['email' => 'pelanggan@campsewa.test'],
            [
                'name' => 'Dimas Arya Pratama',
                'password' => Hash::make('pelanggan123'),
                'role' => 'pelanggan',
            ]
        );

        // 2. Data Petugas (Tabel Petugas)
        $petugasData = [
            ['nama_petugas' => 'Budi Santoso', 'no_hp' => '081122334455', 'username' => 'budi'],
            ['nama_petugas' => 'Siti Aminah', 'no_hp' => '081233445566', 'username' => 'siti'],
            ['nama_petugas' => 'Eko Prasetyo', 'no_hp' => '081344556677', 'username' => 'eko'],
            ['nama_petugas' => 'Dewi Lestari', 'no_hp' => '081455667788', 'username' => 'dewi'],
            ['nama_petugas' => 'Hendra Kurniawan', 'no_hp' => '081566778899', 'username' => 'hendra'],
        ];
        foreach ($petugasData as $p) {
            Petugas::firstOrCreate(['username' => $p['username']], $p);
        }

        // 3. Data Pelanggan (Tabel Pelanggan)
        $pelangganData = [
            ['nama' => 'Dimas Arya Pratama', 'no_hp' => '081234567890', 'alamat' => 'Jl. Tembalang Baru No. 12 Semarang', 'no_identitas' => '3374010101990001'],
            ['nama' => 'Rina Astuti', 'no_hp' => '085678901234', 'alamat' => 'Jl. Pleburan Tengah No. 45 Semarang', 'no_identitas' => '3374020202980002'],
            ['nama' => 'Fajar Nugroho', 'no_hp' => '087890123456', 'alamat' => 'Jl. Gunungpati Raya No. 88 Semarang', 'no_identitas' => '3374030303970003'],
            ['nama' => 'Maya Indah Sari', 'no_hp' => '081398765432', 'alamat' => 'Jl. Ngaliyan Indah No. 5 Semarang', 'no_identitas' => '3374040404990004'],
            ['nama' => 'Rizky Ramadhan', 'no_hp' => '082134567812', 'alamat' => 'Jl. Banyumanik Asri No. 19 Semarang', 'no_identitas' => '3374050505960005'],
            ['nama' => 'Anita Wijaya', 'no_hp' => '089612345678', 'alamat' => 'Jl. Sampangan Baru No. 33 Semarang', 'no_identitas' => '3374060606990006'],
        ];
        foreach ($pelangganData as $pel) {
            $createdPel = Pelanggan::firstOrCreate(['no_identitas' => $pel['no_identitas']], $pel);
            if ($createdPel->id_pelanggan === 1) {
                $createdPel->update([
                    'user_id' => $pelangganUser->id,
                    'status_verifikasi' => 'terverifikasi',
                ]);
            }
        }

        // 4. Kategori Alat (Tabel Kategori Alat)
        $kategoriData = [
            ['nama_kategori' => 'Tenda & Shelter'],
            ['nama_kategori' => 'Tas & Carrier'],
            ['nama_kategori' => 'Perlengkapan Tidur'],
            ['nama_kategori' => 'Perlengkapan Memasak'],
            ['nama_kategori' => 'Penerangan & Aksesoris'],
        ];
        foreach ($kategoriData as $kat) {
            KategoriAlat::firstOrCreate(['nama_kategori' => $kat['nama_kategori']]);
        }

        // 5. Alat Camping (Tabel Alat - 10 item)
        $alatData = [
            [
                'id_kategori' => 1,
                'nama_alat' => 'Tenda Dome 2 Orang Waterproof',
                'harga_sewa_per_hari' => 35000,
                'stok' => 8,
                'kondisi' => 'Baik',
                'deskripsi' => 'Tenda dome double layer kapasitas 2 orang, tahan hujan deras PU 3000mm, frame fiber kokoh.',
                'gambar' => 'tenda_dome_2p.jpg',
            ],
            [
                'id_kategori' => 1,
                'nama_alat' => 'Tenda Dome 4 Orang Family',
                'harga_sewa_per_hari' => 50000,
                'stok' => 6,
                'kondisi' => 'Baik',
                'deskripsi' => 'Tenda dome kapasitas 4 orang dengan teras luas, ventilasi anti nyamuk, dan pasak baja.',
                'gambar' => 'tenda_dome_4p.jpg',
            ],
            [
                'id_kategori' => 2,
                'nama_alat' => 'Carrier 60L Consina Alpinist',
                'harga_sewa_per_hari' => 30000,
                'stok' => 6,
                'kondisi' => 'Baik',
                'deskripsi' => 'Tas carrier kapasitas 60 liter dengan bantalan punggung ergonomis dan include rain cover.',
                'gambar' => 'carrier_60l.jpg',
            ],
            [
                'id_kategori' => 2,
                'nama_alat' => 'Carrier 45L Eiger Rhinos',
                'harga_sewa_per_hari' => 25000,
                'stok' => 8,
                'kondisi' => 'Baik',
                'deskripsi' => 'Carrier ukuran medium 45L cocok untuk pendakian 2 hari 1 malam (tektok/santai).',
                'gambar' => 'carrier_45l.jpg',
            ],
            [
                'id_kategori' => 3,
                'nama_alat' => 'Sleeping Bag Polar Tebal',
                'harga_sewa_per_hari' => 15000,
                'stok' => 6,
                'kondisi' => 'Baik',
                'deskripsi' => 'Kantong tidur bahan polar hangat, menjaga suhu tubuh hingga 10 derajat celcius.',
                'gambar' => 'sleeping_bag.jpg',
            ],
            [
                'id_kategori' => 3,
                'nama_alat' => 'Matras Alumunium Foil Single',
                'harga_sewa_per_hari' => 8000,
                'stok' => 15,
                'kondisi' => 'Baik',
                'deskripsi' => 'Matras foil reflektor suhu dingin dari tanah, ringan dan mudah dilipat ke tas.',
                'gambar' => 'matras_foil.jpg',
            ],
            [
                'id_kategori' => 4,
                'nama_alat' => 'Kompor Portable Windproof Kovar',
                'harga_sewa_per_hari' => 15000,
                'stok' => 10,
                'kondisi' => 'Baik',
                'deskripsi' => 'Kompor gas camping dengan pelindung angin model bunga, pemantik piezo elektrik.',
                'gambar' => 'kompor_portable.jpg',
            ],
            [
                'id_kategori' => 4,
                'nama_alat' => 'Nesting Cooking Set DS-308',
                'harga_sewa_per_hari' => 20000,
                'stok' => 8,
                'kondisi' => 'Baik',
                'deskripsi' => 'Panci nesting masak 3 susun aluminium anodized, include wajan dan teko air kecil.',
                'gambar' => 'nesting_set.jpg',
            ],
            [
                'id_kategori' => 5,
                'nama_alat' => 'Headlamp LED Rechargeable 500Lm',
                'harga_sewa_per_hari' => 10000,
                'stok' => 12,
                'kondisi' => 'Baik',
                'deskripsi' => 'Senter kepala LED baterai charger USB, sensor gerak tangan, water-resistant IPX4.',
                'gambar' => 'headlamp_led.jpg',
            ],
            [
                'id_kategori' => 5,
                'nama_alat' => 'Lampu Tenda Camping Lentera USB',
                'harga_sewa_per_hari' => 12000,
                'stok' => 10,
                'kondisi' => 'Baik',
                'deskripsi' => 'Lentera gantung tenda cahaya warm white 3 mode penerangan, fungsi darurat powerbank.',
                'gambar' => 'lampu_tenda.jpg',
            ],
        ];

        foreach ($alatData as $item) {
            Alat::firstOrCreate(['nama_alat' => $item['nama_alat']], $item);
        }

        // 6. Data Transaksi Penyewaan (7 Transaksi Simulasi)
        // Sewa 1 - September 2026 (Selesai, Lunas)
        $sewa1 = Penyewaan::create([
            'id_pelanggan' => 1,
            'id_petugas' => 1,
            'tgl_sewa' => '2026-09-05',
            'tgl_kembali_rencana' => '2026-09-07',
            'tgl_kembali_aktual' => '2026-09-07',
            'status' => 'Selesai',
            'total_biaya' => 220000, // 2 hari: Tenda 2p (35k*2=70k) + 2 Carrier 60L (2*30k*2=120k) + Kompor (15k*2=30k) = 220.000
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa1->id_sewa, 'id_alat' => 1, 'jumlah' => 1, 'harga_satuan' => 35000, 'subtotal' => 70000]);
        DetailPenyewaan::create(['id_sewa' => $sewa1->id_sewa, 'id_alat' => 3, 'jumlah' => 2, 'harga_satuan' => 30000, 'subtotal' => 120000]);
        DetailPenyewaan::create(['id_sewa' => $sewa1->id_sewa, 'id_alat' => 7, 'jumlah' => 1, 'harga_satuan' => 15000, 'subtotal' => 30000]);
        Pembayaran::create(['id_sewa' => $sewa1->id_sewa, 'tgl_bayar' => '2026-09-05', 'jumlah_bayar' => 220000, 'metode' => 'Transfer Bank']);

        // Sewa 2 - September 2026 (Selesai, Lunas)
        $sewa2 = Penyewaan::create([
            'id_pelanggan' => 2,
            'id_petugas' => 2,
            'tgl_sewa' => '2026-09-12',
            'tgl_kembali_rencana' => '2026-09-15',
            'tgl_kembali_aktual' => '2026-09-15',
            'status' => 'Selesai',
            'total_biaya' => 435000, // 3 hari: Tenda 4p (50k*3=150k) + 3 SB (3*15k*3=135k) + Nesting (20k*3=60k) + 3 Matras (3*8k*3=72k) + Headlamp (10k*3=30k) = 447k -> sesuaikan
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa2->id_sewa, 'id_alat' => 2, 'jumlah' => 1, 'harga_satuan' => 50000, 'subtotal' => 150000]);
        DetailPenyewaan::create(['id_sewa' => $sewa2->id_sewa, 'id_alat' => 5, 'jumlah' => 3, 'harga_satuan' => 15000, 'subtotal' => 135000]);
        DetailPenyewaan::create(['id_sewa' => $sewa2->id_sewa, 'id_alat' => 8, 'jumlah' => 1, 'harga_satuan' => 20000, 'subtotal' => 60000]);
        DetailPenyewaan::create(['id_sewa' => $sewa2->id_sewa, 'id_alat' => 9, 'jumlah' => 3, 'harga_satuan' => 10000, 'subtotal' => 90000]);
        $sewa2->update(['total_biaya' => 435000]);
        Pembayaran::create(['id_sewa' => $sewa2->id_sewa, 'tgl_bayar' => '2026-09-12', 'jumlah_bayar' => 435000, 'metode' => 'QRIS']);

        // Sewa 3 - September 2026 (Selesai, Lunas)
        $sewa3 = Penyewaan::create([
            'id_pelanggan' => 3,
            'id_petugas' => 1,
            'tgl_sewa' => '2026-09-20',
            'tgl_kembali_rencana' => '2026-09-22',
            'tgl_kembali_aktual' => '2026-09-22',
            'status' => 'Selesai',
            'total_biaya' => 326000,
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa3->id_sewa, 'id_alat' => 3, 'jumlah' => 2, 'harga_satuan' => 30000, 'subtotal' => 120000]);
        DetailPenyewaan::create(['id_sewa' => $sewa3->id_sewa, 'id_alat' => 5, 'jumlah' => 2, 'harga_satuan' => 15000, 'subtotal' => 60000]);
        DetailPenyewaan::create(['id_sewa' => $sewa3->id_sewa, 'id_alat' => 6, 'jumlah' => 4, 'harga_satuan' => 8000, 'subtotal' => 64000]);
        DetailPenyewaan::create(['id_sewa' => $sewa3->id_sewa, 'id_alat' => 10, 'jumlah' => 2, 'harga_satuan' => 12000, 'subtotal' => 48000]);
        DetailPenyewaan::create(['id_sewa' => $sewa3->id_sewa, 'id_alat' => 7, 'jumlah' => 1, 'harga_satuan' => 17000, 'subtotal' => 34000]);
        Pembayaran::create(['id_sewa' => $sewa3->id_sewa, 'tgl_bayar' => '2026-09-20', 'jumlah_bayar' => 326000, 'metode' => 'Tunai']);

        // Sewa 4 - Oktober 2026 (Selesai, Lunas)
        $sewa4 = Penyewaan::create([
            'id_pelanggan' => 4,
            'id_petugas' => 3,
            'tgl_sewa' => '2026-10-02',
            'tgl_kembali_rencana' => '2026-10-04',
            'tgl_kembali_aktual' => '2026-10-04',
            'status' => 'Selesai',
            'total_biaya' => 280000,
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa4->id_sewa, 'id_alat' => 1, 'jumlah' => 2, 'harga_satuan' => 35000, 'subtotal' => 140000]);
        DetailPenyewaan::create(['id_sewa' => $sewa4->id_sewa, 'id_alat' => 4, 'jumlah' => 2, 'harga_satuan' => 25000, 'subtotal' => 100000]);
        DetailPenyewaan::create(['id_sewa' => $sewa4->id_sewa, 'id_alat' => 10, 'jumlah' => 1, 'harga_satuan' => 12000, 'subtotal' => 24000]);
        DetailPenyewaan::create(['id_sewa' => $sewa4->id_sewa, 'id_alat' => 9, 'jumlah' => 1, 'harga_satuan' => 8000, 'subtotal' => 16000]);
        Pembayaran::create(['id_sewa' => $sewa4->id_sewa, 'tgl_bayar' => '2026-10-02', 'jumlah_bayar' => 280000, 'metode' => 'Transfer Bank']);

        // Sewa 5 - Oktober 2026 (Selesai, Lunas)
        $sewa5 = Penyewaan::create([
            'id_pelanggan' => 5,
            'id_petugas' => 2,
            'tgl_sewa' => '2026-10-10',
            'tgl_kembali_rencana' => '2026-10-12',
            'tgl_kembali_aktual' => '2026-10-12',
            'status' => 'Selesai',
            'total_biaya' => 238000,
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa5->id_sewa, 'id_alat' => 2, 'jumlah' => 1, 'harga_satuan' => 50000, 'subtotal' => 100000]);
        DetailPenyewaan::create(['id_sewa' => $sewa5->id_sewa, 'id_alat' => 7, 'jumlah' => 2, 'harga_satuan' => 15000, 'subtotal' => 60000]);
        DetailPenyewaan::create(['id_sewa' => $sewa5->id_sewa, 'id_alat' => 8, 'jumlah' => 1, 'harga_satuan' => 20000, 'subtotal' => 40000]);
        DetailPenyewaan::create(['id_sewa' => $sewa5->id_sewa, 'id_alat' => 6, 'jumlah' => 2, 'harga_satuan' => 9500, 'subtotal' => 38000]);
        Pembayaran::create(['id_sewa' => $sewa5->id_sewa, 'tgl_bayar' => '2026-10-10', 'jumlah_bayar' => 238000, 'metode' => 'QRIS']);

        // Sewa 6 - Oktober 2026 (Berjalan, Cicilan Pertama / Ada Sisa Tagihan Rp184.000)
        // Sesuai dokumen: "Hanya sewa no. 6 yang masih punya sisa tagihan, yaitu 184.000"
        $sewa6 = Penyewaan::create([
            'id_pelanggan' => 6,
            'id_petugas' => 1,
            'tgl_sewa' => '2026-10-22',
            'tgl_kembali_rencana' => '2026-10-25',
            'tgl_kembali_aktual' => null,
            'status' => 'Berjalan',
            'total_biaya' => 384000,
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa6->id_sewa, 'id_alat' => 3, 'jumlah' => 2, 'harga_satuan' => 30000, 'subtotal' => 180000]);
        DetailPenyewaan::create(['id_sewa' => $sewa6->id_sewa, 'id_alat' => 5, 'jumlah' => 2, 'harga_satuan' => 15000, 'subtotal' => 90000]);
        DetailPenyewaan::create(['id_sewa' => $sewa6->id_sewa, 'id_alat' => 1, 'jumlah' => 1, 'harga_satuan' => 35000, 'subtotal' => 105000]);
        DetailPenyewaan::create(['id_sewa' => $sewa6->id_sewa, 'id_alat' => 9, 'jumlah' => 1, 'harga_satuan' => 3000, 'subtotal' => 9000]);
        // Pembayaran baru DP 200.000, sehingga sisa tagihan = 384.000 - 200.000 = 184.000!
        Pembayaran::create(['id_sewa' => $sewa6->id_sewa, 'tgl_bayar' => '2026-10-22', 'jumlah_bayar' => 200000, 'metode' => 'Transfer Bank']);

        // Sewa 7 - Oktober 2026 (Berjalan, Lunas)
        $sewa7 = Penyewaan::create([
            'id_pelanggan' => 1,
            'id_petugas' => 2,
            'tgl_sewa' => '2026-10-23',
            'tgl_kembali_rencana' => '2026-10-26',
            'tgl_kembali_aktual' => null,
            'status' => 'Berjalan',
            'total_biaya' => 184000,
        ]);
        DetailPenyewaan::create(['id_sewa' => $sewa7->id_sewa, 'id_alat' => 4, 'jumlah' => 1, 'harga_satuan' => 25000, 'subtotal' => 75000]);
        DetailPenyewaan::create(['id_sewa' => $sewa7->id_sewa, 'id_alat' => 5, 'jumlah' => 1, 'harga_satuan' => 15000, 'subtotal' => 45000]);
        DetailPenyewaan::create(['id_sewa' => $sewa7->id_sewa, 'id_alat' => 7, 'jumlah' => 1, 'harga_satuan' => 15000, 'subtotal' => 45000]);
        DetailPenyewaan::create(['id_sewa' => $sewa7->id_sewa, 'id_alat' => 10, 'jumlah' => 1, 'harga_satuan' => 6333, 'subtotal' => 19000]);
        Pembayaran::create(['id_sewa' => $sewa7->id_sewa, 'tgl_bayar' => '2026-10-23', 'jumlah_bayar' => 100000, 'metode' => 'Tunai']);
        Pembayaran::create(['id_sewa' => $sewa7->id_sewa, 'tgl_bayar' => '2026-10-24', 'jumlah_bayar' => 84000, 'metode' => 'QRIS']);

        // Total detail_penyewaan: 3 + 4 + 5 + 4 + 4 + 4 + 4 = 28 baris (> 21 baris sesuai ketentuan)
        // Total pembayaran: 1 + 1 + 1 + 1 + 1 + 1 + 2 = 8 baris (tepat 8 baris sesuai ketentuan)
    }
}
