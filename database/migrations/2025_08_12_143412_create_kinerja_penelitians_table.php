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
        Schema::create('kinerja_penelitian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kinerja_dosen_id')->constrained('kinerja_dosen')->onDelete('cascade');
            $table->string('judul_penelitian');
            $table->enum('jenis_penelitian', ['Tim', 'Mandiri']);
            $table->enum('peran_penelitian', ['Ketua', 'Anggota']);
            $table->string('sumber_dana');
            $table->bigInteger('jumlah_dana');
            $table->year('tahun_penelitian');
            $table->enum('status_penelitian', ['Sedang Berjalan', 'Selesai']);
            $table->string('output_luaran');
            $table->string('bukti_path')->nullable();
            $table->enum('bentuk_penelitian', ['Buku', 'Monograf', 'Jurnal Internasional', 'Jurnal Nasional', 'Prosiding', 'Penelitian Non-Publikasi']);
            $table->string('nomor_volume_isbn')->nullable();
            $table->string('penerbit')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->integer('skor')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinerja_penelitian');
    }
};
