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
        Schema::create('permohonan_penarikan', function (Blueprint $table) {
            $table->integer('kode_penarikan')->primary();
            $table->dateTime('tanggal');
            $table->integer('no_anggota');
            $table->decimal('permohonan', 18, 2);
            $table->decimal('disetujui', 18, 2);
            $table->decimal('diambil', 18, 2);
            $table->text('catatan')->nullable();
            $table->string('status', 50);
            $table->integer('kode_simpanan');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign Key Constraints
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota')->onDelete('cascade');
            $table->foreign('kode_simpanan')->references('kode_simpanan')->on('simpanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_penarikan');
    }
};
