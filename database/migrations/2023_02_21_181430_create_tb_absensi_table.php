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
        Schema::create('tb_absensi', function (Blueprint $table) {
            $table->string('kode_absen')->primary();
            $table->string('kode_pertemuan');
            $table->foreign('kode_pertemuan')->references('kode_pertemuan')->on('tb_pertemuan')->onDelete('cascade');
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('tb_mahasiswa')->onDelete('cascade');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpha']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_absensi');
    }
};
