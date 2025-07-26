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
        Schema::create('soal_ujians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ujian_id')->constrained()->onDelete('cascade');
    $table->text('pertanyaan');
    $table->string('opsi_a');
    $table->string('opsi_b');
    $table->string('opsi_c');
    $table->string('opsi_d');
    $table->string('jawaban_benar'); // contoh: 'a', 'b', ...
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_ujians');
    }
};
