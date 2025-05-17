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
        Schema::create('saldo_kas_kecil', function (Blueprint $table) {
            $table->integer('kode_saldo')->primary();
            $table->decimal('saldo', 18, 2);
            $table->dateTime('createdon')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->dateTime('modifiedon')->nullable();
            $table->string('modifiedby', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_kas_kecil');
    }
};
