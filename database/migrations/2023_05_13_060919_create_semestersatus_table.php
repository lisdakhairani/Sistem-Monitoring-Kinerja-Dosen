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
        Schema::create('semestersatus', function (Blueprint $table) {
            $table->id();
            $table->string('kodemk')->nullable();
            $table->string('matakuliah')->nullable();
            $table->string('sks')->nullable();
            $table->string('filedata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestersatus');
    }
};
