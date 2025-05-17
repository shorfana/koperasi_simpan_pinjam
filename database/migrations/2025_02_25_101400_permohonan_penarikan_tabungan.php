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
        Schema::create('permohonan_penarikan_tabungan', function (Blueprint $table) {
            $table->integer('kode_penarikan')->primary();
            $table->integer('no_anggota');
            $table->dateTime('tanggal');
            $table->string('nasabah', 100);
            $table->decimal('permohonan', 18, 2);
            $table->decimal('disetujui', 18, 2);
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
        Schema::dropIfExists('permohonan_penarikan_tabungan');
    }
};
