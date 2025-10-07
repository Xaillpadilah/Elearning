<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('soal_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained()->onDelete('cascade');
            $table->text('pertanyaan');
            $table->json('pilihan');
            $table->string('jawaban_benar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_tugas');
    }
};
