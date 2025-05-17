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
        Schema::create('jenis_rekening', function (Blueprint $table) {
            $table->integer('kode_jenis_rekening')->primary();
            $table->string('nama', 100);
            $table->text('keterangan')->nullable();
            $table->decimal('biaya_administrasi', 18, 2)->default(0);
            $table->decimal('biaya_admin_bulanan', 18, 2)->default(0);
            $table->decimal('limit_transfer', 18, 2)->default(0);
            $table->decimal('limit_penarikan', 18, 2)->default(0);
            $table->string('status', 50);
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_rekening');
    }
};
