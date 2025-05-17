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
        Schema::create('penarikan_investasi', function (Blueprint $table) {
            $table->integer('kode_penarikan')->primary();
            $table->dateTime('tanggal');
            $table->integer('no_anggota');
            $table->decimal('permohonan', 18, 2);
            $table->decimal('investasi_diambil', 18, 2);
            $table->string('kode_akun_diambil', 50);
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('penarikan_investasi');
    }
};
