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
      Schema::create('rekap_pembelajaran_semester', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->string('semester'); // contoh: "Semester 1", "Semester 2"
            $table->year('tahun_ajaran'); // contoh: 2025

            $table->integer('jumlah_hadir')->default(0);
            $table->integer('jumlah_izin')->default(0);
            $table->integer('jumlah_sakit')->default(0);
            $table->integer('jumlah_alfa')->default(0);

            $table->integer('total_tugas')->default(0);
            $table->integer('tugas_selesai')->default(0);

            $table->float('rata_rata_nilai')->nullable();
            $table->text('catatan_guru')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_pembelajaran_semesters');
    }
};
