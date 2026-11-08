<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penyewaan', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_sewa');
            $table->unsignedInteger('id_alat');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 0);
            $table->decimal('subtotal', 12, 0);
            $table->timestamps();

            $table->foreign('id_sewa')
                  ->references('id_sewa')
                  ->on('penyewaan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_alat')
                  ->references('id_alat')
                  ->on('alat')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penyewaan');
    }
};
