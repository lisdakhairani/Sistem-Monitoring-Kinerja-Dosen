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
        Schema::create('kinerja_pengajaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kinerja_dosen_id')->constrained('kinerja_dosen')->onDelete('cascade');
            $table->string('nama_matkul');
            $table->string('kode_matkul');
            $table->integer('sks');
            $table->string('semester');
            $table->string('tahun_ajaran');
            $table->integer('jumlah_pertemuan');
            $table->string('bukti_path');
            $table->enum('jenis_pengajaran', ['Tim', 'Mandiri']);
            $table->integer('skor')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinerja_pengajaran');
    }
};
