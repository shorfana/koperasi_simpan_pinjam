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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->integer('kode_pembelian')->primary();
            $table->dateTime('tanggal');
            $table->string('kategori', 50);
            $table->string('kode_akun', 50);
            $table->integer('no_anggota');
            $table->decimal('nominal', 18, 2);
            $table->decimal('nominal_bayar', 18, 2);
            $table->dateTime('tgl_jatuh_tempo')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('bulan')->nullable();
            $table->decimal('cicilan_perbulan', 18, 2)->nullable();
            $table->string('status', 50);
            $table->integer('kode_kategori_pembelian');
            $table->integer('kode_pembayaran')->nullable();
            $table->integer('kode_limit_pembelian');

            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign Keys
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
            $table->foreign('kode_kategori_pembelian')->references('kode_kategori_pembelian')->on('kategori_pembelian');
            $table->foreign('kode_pembayaran')->references('kode_pembayaran')->on('pembayaran_pembelian');
            $table->foreign('kode_limit_pembelian')->references('kode_limit_pembelian')->on('limit_pembelian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
