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
        Schema::create('kategori_pembelian', function (Blueprint $table) {
            $table->integer('kode_kategori_pembelian')->primary();
            $table->string('nama', 100);
            $table->text('keterangan')->nullable();
            $table->decimal('margin', 5, 2)->nullable();
            $table->decimal('pembulatan', 18, 2)->nullable();
            $table->string('gambar', 255)->nullable();
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
        Schema::dropIfExists('kategori_pembelian');
    }
};
