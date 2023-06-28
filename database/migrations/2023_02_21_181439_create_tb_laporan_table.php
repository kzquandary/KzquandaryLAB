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
        Schema::create('tb_laporan', function (Blueprint $table) {
            $table->string('kode_laporan')->primary();
            $table->string('kode_pertemuan');
            $table->foreign('kode_pertemuan')->references('kode_pertemuan')->on('tb_pertemuan')->onDelete('cascade');
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('tb_mahasiswa')->onDelete('cascade');
            $table->enum('status', ['Mengumpulkan', 'Telat', 'Tidak Mengumpulkan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_laporan');
    }
};
