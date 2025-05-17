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
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->integer('kode_pemasukan')->primary();
            $table->string('kategori', 50);
            $table->string('kodeakun', 50);
            $table->string('kegiatan', 100);
            $table->text('keterangan')->nullable();
            $table->decimal('total_nominal', 18, 2);
            $table->dateTime('tanggal');
            $table->string('status', 50);
            $table->integer('kode_kategori_pemasukan')->nullable();
            $table->integer('no_anggota')->nullable();
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign keys
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota')->onDelete('set null');
            $table->foreign('kode_kategori_pemasukan')->references('kode_kategori_pemasukan')->on('kategori_pemasukan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};
