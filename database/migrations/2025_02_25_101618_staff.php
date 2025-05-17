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
        Schema::create('staff', function (Blueprint $table) {
            $table->integer('kode_akun')->primary();
            $table->string('nip', 20)->unique();
            $table->string('email', 100)->unique();
            $table->string('nama', 100);
            $table->dateTime('tgl_lahir');
            $table->string('nohp', 15);
            $table->string('kota_alamat', 100);
            $table->string('foto', 255)->nullable();
            $table->string('type', 50);
            $table->string('status', 50);
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
