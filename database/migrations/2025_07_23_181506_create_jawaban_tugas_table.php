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
        Schema::create('jawaban_tugas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tugas_id')->constrained()->onDelete('cascade');
    $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
    $table->text('jawaban')->nullable();
    $table->string('file')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_tugas');
    }
};
