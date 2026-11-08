-- Database: db_penyewaan_camping
-- Sistem Informasi Penyewaan Alat Camping (CampSewa)
-- Kompatibel dengan MySQL 8.x dan MariaDB 10.x

CREATE DATABASE IF NOT EXISTS `db_penyewaan_camping` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_penyewaan_camping`;

-- 1. Tabel users (Autentikasi Admin dan Petugas)
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel pelanggan (Entitas Utama 1)
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `no_hp` VARCHAR(15) NOT NULL,
  `alamat` VARCHAR(200) NULL,
  `no_identitas` VARCHAR(20) NOT NULL UNIQUE,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel petugas (Entitas Utama 2)
CREATE TABLE IF NOT EXISTS `petugas` (
  `id_petugas` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama_petugas` VARCHAR(100) NOT NULL,
  `no_hp` VARCHAR(15) NULL,
  `username` VARCHAR(30) NOT NULL UNIQUE,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel kategori_alat (Entitas Utama 3)
CREATE TABLE IF NOT EXISTS `kategori_alat` (
  `id_kategori` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama_kategori` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel alat (Entitas Utama 4)
CREATE TABLE IF NOT EXISTS `alat` (
  `id_alat` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_kategori` INT UNSIGNED NOT NULL,
  `nama_alat` VARCHAR(100) NOT NULL,
  `harga_sewa_per_hari` DECIMAL(10,0) NOT NULL,
  `stok` INT NOT NULL DEFAULT 0,
  `kondisi` VARCHAR(30) NOT NULL DEFAULT 'Baik',
  `deskripsi` TEXT NULL,
  `gambar` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_alat_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_alat` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel penyewaan (Entitas Utama 5)
CREATE TABLE IF NOT EXISTS `penyewaan` (
  `id_sewa` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_pelanggan` INT UNSIGNED NOT NULL,
  `id_petugas` INT UNSIGNED NULL,
  `tgl_sewa` DATE NOT NULL,
  `tgl_kembali_rencana` DATE NOT NULL,
  `tgl_kembali_aktual` DATE NULL,
  `status` VARCHAR(30) NOT NULL DEFAULT 'Berjalan',
  `total_biaya` DECIMAL(12,0) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_sewa_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_sewa_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabel detail_penyewaan (Entitas Utama 6)
CREATE TABLE IF NOT EXISTS `detail_penyewaan` (
  `id_detail` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_sewa` INT UNSIGNED NOT NULL,
  `id_alat` INT UNSIGNED NOT NULL,
  `jumlah` INT NOT NULL,
  `harga_satuan` DECIMAL(10,0) NOT NULL,
  `subtotal` DECIMAL(12,0) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_detail_sewa` FOREIGN KEY (`id_sewa`) REFERENCES `penyewaan` (`id_sewa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_detail_alat` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id_alat`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Tabel pembayaran (Entitas Utama 7)
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id_bayar` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_sewa` INT UNSIGNED NOT NULL,
  `tgl_bayar` DATE NOT NULL,
  `jumlah_bayar` DECIMAL(12,0) NOT NULL,
  `metode` VARCHAR(30) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_pembayaran_sewa` FOREIGN KEY (`id_sewa`) REFERENCES `penyewaan` (`id_sewa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
