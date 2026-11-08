<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->increments('id_alat');
            $table->unsignedInteger('id_kategori');
            $table->string('nama_alat', 100);
            $table->decimal('harga_sewa_per_hari', 10, 0);
            $table->integer('stok')->default(0);
            $table->string('kondisi', 30)->default('Baik');
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori_alat')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
