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
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('siswa_id');
            $table->text('jawaban')->nullable(); // Untuk jawaban text
            $table->string('file_jawaban')->nullable(); // Untuk jawaban file
            $table->integer('skor')->nullable(); // Untuk nilai kuis (opsional)
            $table->timestamps();

            // Foreign key
            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade'); // Jika siswa di tabel users
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_tugas');
    }

};
