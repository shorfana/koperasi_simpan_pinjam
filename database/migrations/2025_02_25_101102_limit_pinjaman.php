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
        Schema::create('limit_pinjaman', function (Blueprint $table) {
            $table->integer('kode_limit_pinjaman')->primary();
            $table->string('jenis', 50);
            $table->decimal('min_nominal', 18, 2);
            $table->decimal('max_nominal', 18, 2);
            $table->integer('min_bulan');
            $table->integer('max_bulan');
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
        Schema::dropIfExists('limit_pinjaman');
    }
};
