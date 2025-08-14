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
        Schema::create('kinerja_pengabdian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kinerja_dosen_id')->constrained('kinerja_dosen')->onDelete('cascade');
            $table->string('judul_kegiatan');
            $table->string('jenis_kegiatan');
            $table->enum('peran_pengabdian', ['Ketua', 'Anggota']);
            $table->string('lokasi');
            $table->year('tahun_kegiatan');
            $table->string('sumber_dana');
            $table->bigInteger('jumlah_dana');
            $table->text('output');
            $table->string('bukti_path')->nullable();
            $table->enum('tingkat_kegiatan', ['Lokal', 'Nasional', 'Internasional']);
            $table->integer('skor')->default(0);
            $table->string('bidang_keahlian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinerja_pengabdian');
    }
};
