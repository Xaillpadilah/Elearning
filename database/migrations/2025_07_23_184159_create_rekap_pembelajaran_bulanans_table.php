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
         Schema::create('rekap_pembelajaran_bulanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->date('tanggal'); // tanggal rekap harian

            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'alfa']);
            $table->integer('jumlah_tugas')->default(0);
            $table->integer('jumlah_tugas_selesai')->default(0);

            $table->float('rata_rata_nilai')->nullable(); // nilai hari itu atau rata-rata
            $table->text('catatan_guru')->nullable();     // komentar atau evaluasi

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_pembelajaran_bulanans');
    }
};
