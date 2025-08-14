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
        Schema::create('kinerja_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dosen');
            $table->unsignedBigInteger('id_semester');
            $table->string('status_penilaian', 20)->default('Menunggu');
            $table->date('tanggal_pengisian')->nullable();
            $table->date('tanggal_validasi')->nullable();
            $table->unsignedBigInteger('id_validator')->nullable();
            $table->decimal('total_skor', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->integer('is_updated')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_dosen')->references('id')->on('users');
            $table->foreign('id_validator')->references('id')->on('users');
            $table->foreign('id_semester')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinerja_dosen');
    }
};
