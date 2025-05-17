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
        Schema::create('pembayaran_pinjaman', function (Blueprint $table) {
            $table->integer('kode_pembayaran')->primary();
            $table->integer('no_anggota');
            $table->decimal('total_pinjaman', 18, 2);
            $table->decimal('dibayar', 18, 2);
            $table->decimal('sisa', 18, 2);
            $table->integer('total_bulan');
            $table->string('status', 50);
            $table->integer('kode_pinjaman');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign keys
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
            $table->foreign('kode_pinjaman')->references('kode_pinjaman')->on('pinjaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pinjaman');
    }
};
