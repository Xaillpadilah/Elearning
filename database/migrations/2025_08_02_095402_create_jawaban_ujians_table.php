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
        Schema::create('jawaban_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // siswa
            $table->foreignId('ujian_id')->constrained()->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal_ujians')->onDelete('cascade');
            $table->string('jawaban')->nullable(); // A/B/C/D atau teks
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_ujians');
    }
};

