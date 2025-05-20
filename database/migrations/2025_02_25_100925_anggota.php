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
        Schema::create('anggota', function (Blueprint $table) {
            $table->integer('no_anggota')->primary();
            $table->string('nip', 20)->nullable();
            $table->string('ktp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nama', 100);
            $table->dateTime('tgl_lahir')->nullable();
            $table->string('nohp', 15)->nullable();
            $table->dateTime('tgl_aktivasi')->nullable();
            $table->dateTime('tgl_keluar')->nullable();
            $table->decimal('simpanan_wajib', 18, 2)->default(0);
            $table->string('rekening', 20)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_pensiun', 100)->nullable();
            $table->string('jenis_pensiun', 100)->nullable();
            $table->string('simpanan_pokok', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('is_deleted', 100)->nullable();
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
