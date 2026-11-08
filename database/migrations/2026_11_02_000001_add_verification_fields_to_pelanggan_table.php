<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom status_verifikasi dan jumlah_terlambat ke tabel pelanggan.
     * Data lama diberi status_verifikasi = 'terverifikasi'.
     * Default setelah update data lama diubah menjadi 'belum_verifikasi'
     * agar pelanggan baru yang daftar perlu verifikasi terlebih dahulu.
     */
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // Tambah dengan default sementara 'terverifikasi' agar baris lama langsung valid
            $table->string('status_verifikasi', 20)->default('terverifikasi')->after('no_identitas');
            $table->unsignedInteger('jumlah_terlambat')->default(0)->after('status_verifikasi');
        });

        // Pastikan semua baris lama mendapat nilai 'terverifikasi'
        DB::table('pelanggan')->update(['status_verifikasi' => 'terverifikasi']);

        // Ubah default menjadi 'belum_verifikasi' untuk pelanggan baru
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('status_verifikasi', 20)->default('belum_verifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi', 'jumlah_terlambat']);
        });
    }
};

