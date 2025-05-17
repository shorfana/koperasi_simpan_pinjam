<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->integer('kode_pengeluaran')->primary();
            $table->string('kategori', 50);
            $table->string('kodeakun', 50);
            $table->string('kegiatan', 100);
            $table->text('keterangan')->nullable();
            $table->decimal('total_nominal', 18, 2);
            $table->decimal('total_realisasi', 18, 2);
            $table->decimal('sisa', 18, 2);
            $table->dateTime('tanggal');
            $table->string('status', 50);
            $table->integer('kode_realisasi')->nullable();
            $table->integer('kode_kategori_pengeluaran')->nullable();
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign Keys
            $table->foreign('kode_realisasi')->references('kode_realisasi')->on('realisasi_pengeluaran');
            $table->foreign('kode_kategori_pengeluaran')->references('kode_kategori_pengeluaran')->on('kategori_pengeluaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
