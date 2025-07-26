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
      Schema::create('penilaians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');

            // Optional jika terkait dengan tugas/ujian
            $table->foreignId('ujian_id')->nullable()->constrained('ujians')->onDelete('set null');
            $table->foreignId('tugas_id')->nullable()->constrained('tugas')->onDelete('set null');

            // Kolom nilai terpisah (wajib diisi, tidak nullable)
            $table->float('nilai_tugas');
            $table->float('nilai_kuis');
            $table->float('nilai_uts');
            $table->float('nilai_uas');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
