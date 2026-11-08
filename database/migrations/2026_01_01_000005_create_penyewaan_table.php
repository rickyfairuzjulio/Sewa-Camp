<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->increments('id_sewa');
            $table->unsignedInteger('id_pelanggan');
            $table->unsignedInteger('id_petugas')->nullable();
            $table->date('tgl_sewa');
            $table->date('tgl_kembali_rencana');
            $table->date('tgl_kembali_aktual')->nullable();
            $table->string('status', 30)->default('Berjalan');
            $table->decimal('total_biaya', 12, 0)->default(0);
            $table->timestamps();

            $table->foreign('id_pelanggan')
                  ->references('id_pelanggan')
                  ->on('pelanggan')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_petugas')
                  ->references('id_petugas')
                  ->on('petugas')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
