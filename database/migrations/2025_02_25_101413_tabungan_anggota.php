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
        Schema::create('tabungan_anggota', function (Blueprint $table) {
            $table->integer('kode_tabungan')->primary();
            $table->integer('no_anggota');
            $table->dateTime('tanggal');
            $table->string('nasabah', 100);
            $table->string('rekening', 20);
            $table->string('penerima', 100);
            $table->decimal('nominal', 18, 2);
            $table->string('status', 50);
            $table->integer('kode_penarikan')->nullable();
            $table->integer('kode_kredit')->nullable();
            $table->integer('kode_pembayaran')->nullable();
            $table->integer('kode_jenis_rekening')->nullable();
            $table->integer('kode_jenis_nasabah')->nullable();
            $table->integer('kode_jenis_pinjaman')->nullable();
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign Keys
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
            $table->foreign('kode_penarikan')->references('kode_penarikan')->on('permohonan_penarikan_tabungan');
            $table->foreign('kode_kredit')->references('kode_kredit')->on('kredit_tabungan');
            $table->foreign('kode_pembayaran')->references('kode_pembayaran')->on('pembayaran_kredit_tabungan');
            $table->foreign('kode_jenis_rekening')->references('kode_jenis_rekening')->on('jenis_rekening');
            $table->foreign('kode_jenis_nasabah')->references('kode_jenis_nasabah')->on('jenis_nasabah');
            $table->foreign('kode_jenis_pinjaman')->references('kode_jenis_pinjaman')->on('jenis_pinjaman_tabungan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabungan_anggota');
    }
};
