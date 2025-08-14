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
        Schema::create('pangkat', function (Blueprint $table) {
            $table->id('id_pangkat');
            $table->string('nama_pangkat', 50)->unique();
            $table->string('golongan', 5);
            $table->timestamps(); // opsional, jika ingin created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pangkat');
    }
};
