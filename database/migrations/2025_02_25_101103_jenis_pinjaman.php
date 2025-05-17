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
        Schema::create('jenis_pinjaman', function (Blueprint $table) {
            $table->integer('kode_jenis_pinjaman')->primary();
            $table->string('nama', 100);
            $table->text('keterangan')->nullable();
            $table->decimal('presentase', 5, 2);
            $table->decimal('nominal', 18, 2);
            $table->decimal('nominal_denda', 18, 2);
            $table->string('status_denda', 50);
            $table->string('status', 50);
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
        Schema::dropIfExists('jenis_pinjaman');
    }
};
