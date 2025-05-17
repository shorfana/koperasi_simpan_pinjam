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
        Schema::create('pembayaran_investasi', function (Blueprint $table) {
            $table->integer('kode_pembayaran')->primary();
            $table->dateTime('tanggal');
            $table->string('jenis', 50);
            $table->integer('no_anggota');
            $table->decimal('total_investasi', 18, 2);
            $table->decimal('dibayar', 18, 2);
            $table->decimal('sisa', 18, 2);
            $table->integer('total_bulan');
            $table->integer('total_bulan_dibayar');
            $table->integer('total_bulan_sisa');
            $table->string('status', 50);
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign key
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_investasi');
    }
};
