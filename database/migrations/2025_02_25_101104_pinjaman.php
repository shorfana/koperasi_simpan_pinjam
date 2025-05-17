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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->integer('kode_pinjaman')->primary();
            $table->dateTime('tanggal');
            $table->string('jenis_kode_kas', 50);
            $table->integer('no_anggota');
            $table->string('jaminan', 250)->nullable();
            $table->decimal('nominal_pinjaman', 18, 2);
            $table->dateTime('tgl_jatuh_tempo');
            $table->text('keterangan')->nullable();
            $table->integer('bulan');
            $table->decimal('cicilan_perbulan', 18, 2);
            $table->string('status', 50);
            $table->integer('kode_jenis_pinjaman');
            $table->integer('kode_limit_pinjaman');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();
            $table->string('is_deleted', 50)->nullable();

            // Foreign Key Constraints
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota')->onDelete('cascade');
            $table->foreign('kode_jenis_pinjaman')->references('kode_jenis_pinjaman')->on('jenis_pinjaman')->onDelete('cascade');
            $table->foreign('kode_limit_pinjaman')->references('kode_limit_pinjaman')->on('limit_pinjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
