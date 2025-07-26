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
         Schema::create('jadwals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
        $table->foreignId('mapel_id')->constrained()->onDelete('cascade');
        $table->foreignId('guru_id')->constrained()->onDelete('cascade'); // relasi ke guru
        $table->string('hari');
        $table->string('jam');
        $table->enum('tipe_ruangan', ['online', 'offline']);
        $table->string('ruangan')->nullable(); // bisa nama ruangan atau link
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
