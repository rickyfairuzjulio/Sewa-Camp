<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    protected function createPublicHomepageSchema(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('role')->default('pelanggan');
            $table->timestamps();
        });

        Schema::create('kategori_alat', function (Blueprint $table): void {
            $table->increments('id_kategori');
            $table->string('nama_kategori');
            $table->timestamps();
        });

        Schema::create('alat', function (Blueprint $table): void {
            $table->increments('id_alat');
            $table->unsignedInteger('id_kategori');
            $table->string('nama_alat');
            $table->decimal('harga_sewa_per_hari', 10, 0);
            $table->integer('stok')->default(0);
            $table->string('kondisi')->default('Baik');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        Schema::create('pelanggan', function (Blueprint $table): void {
            $table->increments('id_pelanggan');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama');
            $table->string('no_hp');
            $table->string('alamat')->nullable();
            $table->string('no_identitas')->unique();
            $table->string('status_verifikasi')->default('belum_verifikasi');
            $table->timestamps();
        });

        Schema::create('petugas', function (Blueprint $table): void {
            $table->increments('id_petugas');
            $table->string('nama_petugas');
            $table->string('no_hp');
            $table->string('username');
            $table->timestamps();
        });

        Schema::create('penyewaan', function (Blueprint $table): void {
            $table->increments('id_sewa');
            $table->unsignedInteger('id_pelanggan');
            $table->unsignedInteger('id_petugas')->nullable();
            $table->date('tgl_sewa');
            $table->date('tgl_kembali_rencana');
            $table->date('tgl_kembali_aktual')->nullable();
            $table->string('status');
            $table->decimal('total_biaya', 12, 0);
            $table->timestamps();
        });

        Schema::create('detail_penyewaan', function (Blueprint $table): void {
            $table->increments('id_detail');
            $table->unsignedInteger('id_sewa');
            $table->unsignedInteger('id_alat');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 0);
            $table->decimal('subtotal', 12, 0);
            $table->timestamps();
        });

        Schema::create('pembayaran', function (Blueprint $table): void {
            $table->increments('id_bayar');
            $table->unsignedInteger('id_sewa');
            $table->date('tgl_bayar');
            $table->decimal('jumlah_bayar', 12, 0);
            $table->string('metode');
            $table->timestamps();
        });
    }
}
