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
        Schema::create('publikasi_nasionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->string('program_studi')->uniqid();            
            $table->string('nama')->uniqid();
            $table->string('kategori')->uniqid();
            $table->string('nama_jurnal')->uniqid();
            $table->string('nama_judul')->uniqid();
            $table->string('link_jurnal')->uniqid();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi_nasionals');
    }
};
