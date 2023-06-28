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
        Schema::create('tb_nilai', function (Blueprint $table) {
            $table->string('kode_nilai')->primary();
            $table->string('kode_laporan');
            $table->foreign('kode_laporan')->references('kode_laporan')->on('tb_laporan')->onDelete('cascade');
            $table->string('kode_pertemuan');
            $table->foreign('kode_pertemuan')->references('kode_pertemuan')->on('tb_pertemuan')->onDelete('cascade');
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('tb_mahasiswa')->onDelete('cascade');
            $table->string('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_nilai');
    }
};
