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
        Schema::create('mst_karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->integer('nik');
            $table->string('nama', 128);
            $table->string('telp', 16);
            $table->integer('id_jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_karyawan');
    }
};
