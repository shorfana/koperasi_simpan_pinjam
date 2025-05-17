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
        Schema::create('simpanan', function (Blueprint $table) {
            $table->integer('kode_simpanan')->primary();
            $table->dateTime('tanggal');
            $table->integer('no_anggota');
            $table->string('jenis_simpanan', 50);
            $table->string('penerima', 100);
            $table->decimal('nominal', 18, 2);
            $table->string('status', 50);
            $table->integer('kode_jenis_simpan');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();

            // Foreign Key Constraint
            $table->foreign('no_anggota')->references('no_anggota')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan');
    }
};
