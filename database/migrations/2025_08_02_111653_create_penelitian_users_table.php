<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penelitian_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('judul_penelitian');
            $table->string('jenis_penelitian');
            $table->string('peran');
            $table->string('sumber_dana')->nullable();
            $table->integer('jumlah_dana')->nullable();
            $table->string('tahun_kegiatan');
            $table->string('status');
            $table->json('output')->nullable();
            $table->json('file_bukti')->nullable();
            $table->string('nilai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penelitian_users');
    }
};
