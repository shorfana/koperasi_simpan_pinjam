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
        Schema::create('investasi', function (Blueprint $table) {
            $table->integer('kode_investasi')->primary();
            $table->dateTime('tanggal');
            $table->string('jenis', 50);
            $table->integer('no_anggota');
            $table->decimal('nominal', 18, 2);
            $table->text('keterangan')->nullable();
            $table->integer('bulan');
            $table->decimal('cicilan_perbulan', 18, 2);
            $table->string('status', 50);
            $table->integer('kode_pembayaran')->nullable();
            $table->integer('kode_penarikan')->nullable();
            $table->integer('kode_jenis_investasi')->nullable();
            $table->integer('kode_limit_investasi')->nullable();
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign keys
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
            $table->foreign('kode_pembayaran')->references('kode_pembayaran')->on('pembayaran_investasi');
            $table->foreign('kode_penarikan')->references('kode_penarikan')->on('penarikan_investasi');
            $table->foreign('kode_jenis_investasi')->references('kode_jenis_investasi')->on('jenis_investasi');
            $table->foreign('kode_limit_investasi')->references('kode_limit_investasi')->on('limit_investasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investasi');
    }
};
