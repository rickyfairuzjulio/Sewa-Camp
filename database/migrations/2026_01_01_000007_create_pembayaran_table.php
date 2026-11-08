<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id_bayar');
            $table->unsignedInteger('id_sewa');
            $table->date('tgl_bayar');
            $table->decimal('jumlah_bayar', 12, 0);
            $table->string('metode', 30);
            $table->timestamps();

            $table->foreign('id_sewa')
                  ->references('id_sewa')
                  ->on('penyewaan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
