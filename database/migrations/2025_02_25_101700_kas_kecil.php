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
        Schema::create('kas_kecil', function (Blueprint $table) {
            $table->integer('kode_kas_kecil')->primary();
            $table->dateTime('tanggal');
            $table->string('kode_akun', 50);
            $table->decimal('saldo_awal', 18, 2);
            $table->decimal('nominal', 18, 2);
            $table->decimal('realisasi', 18, 2);
            $table->decimal('sisa', 18, 2);
            $table->string('status', 50);
            $table->integer('kode_saldo');
            $table->integer('kode_realisasi');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign keys
            $table->foreign('kode_saldo')->references('kode_saldo')->on('saldo_kas_kecil');
            $table->foreign('kode_realisasi')->references('kode_realisasi')->on('realisasi_kas_kecil');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_kecil');
    }
};
