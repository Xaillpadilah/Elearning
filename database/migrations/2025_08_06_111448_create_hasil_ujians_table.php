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
        Schema::create('hasil_ujians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained('users');
    $table->foreignId('ujian_id')->constrained('ujians');
    $table->integer('jumlah_soal');
    $table->integer('jumlah_benar');
    $table->integer('jumlah_salah');
    $table->double('skor');
    $table->longText('detail_salah')->nullable(); // JSON
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujians');
    }
};
