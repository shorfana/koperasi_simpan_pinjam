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
        Schema::create('kredit_tabungan', function (Blueprint $table) {
            $table->integer('kode_kredit')->primary();
            $table->integer('no_anggota');
            $table->dateTime('tanggal');
            $table->string('jenis', 50);
            $table->string('kodekas', 50);
            $table->string('nasabah', 100);
            $table->decimal('nominal_pinjam', 18, 2);
            $table->decimal('nominal', 18, 2);
            $table->dateTime('tgl_jatuh_tempo');
            $table->text('keterangan')->nullable();
            $table->integer('bulan');
            $table->decimal('cicilan_perbulan', 18, 2);
            $table->string('status', 50);
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign Key
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kredit_tabungan');
    }
};
