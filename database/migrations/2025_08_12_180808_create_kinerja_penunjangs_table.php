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
        Schema::create('kinerja_penunjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kinerja_dosen_id')->constrained('kinerja_dosen')->onDelete('cascade');
            $table->enum('jenis_kegiatan', [
                'Reviewer Jurnal',
                'Narasumber / Moderator',
                'Panitia Kegiatan Ilmiah',
                'Pembicara Seminar',
                'Anggota Organisasi Profesi',
                'Sertifikasi Kompetensi'
            ]);
            $table->string('nama_kegiatan');
            $table->enum('tingkat_kegiatan', ['Lokal', 'Nasional', 'Internasional']);
            $table->date('tanggal_kegiatan');
            $table->string('institusi_penyelenggara');
            $table->string('bukti_path')->nullable();
            $table->integer('skor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinerja_penunjang');
    }
};