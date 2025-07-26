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
        Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
        $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
        $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');

        $table->date('tanggal');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');
        $table->string('keterangan')->nullable();

        $table->timestamps();

        $table->unique(['siswa_id', 'tanggal', 'mapel_id'], 'unique_absen_per_hari');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
