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
       Schema::create('ujians', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->date('tanggal');
    $table->text('keterangan')->nullable();

    $table->enum('tipe_ujian', ['pilihan_ganda', 'essai', 'campuran'])->default('pilihan_ganda'); // jenis ujian
    $table->string('file_soal')->nullable(); // untuk upload file soal (PDF/DOCX dll)
 $table->longText('isi_soal')->nullable(); // ✅ kolom tambahan untuk menyimpan hasil convert isi soal dari PDF
    $table->foreignId('guru_mapel_kelas_id')->constrained('guru_mapel_kelas')->onDelete('cascade');

    $table->boolean('acak_soal')->default(false); // untuk acak soal
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
