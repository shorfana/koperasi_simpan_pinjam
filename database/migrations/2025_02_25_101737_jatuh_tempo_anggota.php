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
        Schema::create('jatuh_tempo_anggota', function (Blueprint $table) {
            $table->integer('kode_jatuh_tempo')->primary();
            $table->string('kode', 50);
            $table->string('jenis', 50);
            $table->integer('no_anggota');
            $table->integer('bulanke');
            $table->decimal('angsuran_pokok', 18, 2);
            $table->decimal('angsuran_bagi_hasil', 18, 2);
            $table->decimal('jumlah_angsuran', 18, 2);
            $table->dateTime('tgl_jatuh_tempo');
            $table->integer('selisih_hari');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign key constraint
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jatuh_tempo_anggota');
    }
};
