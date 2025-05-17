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
        Schema::create('realisasi_pengeluaran', function (Blueprint $table) {
            $table->integer('kode_realisasi')->primary();
            $table->string('kategori', 50);
            $table->string('kegiatan', 100);
            $table->decimal('total_nominal', 18, 2);
            $table->decimal('total_realisasi', 18, 2);
            $table->decimal('sisa', 18, 2);
            $table->integer('total_item');
            $table->integer('total_item_realisasi');
            $table->integer('sisa_item');
            $table->dateTime('tanggal');
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasi_pengeluaran');
    }
};
