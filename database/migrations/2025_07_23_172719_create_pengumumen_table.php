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
         Schema::create('pengumumen', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->date('tanggal_pengumuman'); // Tanggal ditambahkan
            $table->enum('ditujukan_kepada', ['semua', 'guru', 'siswa', 'orangtua']);
            $table->unsignedBigInteger('dibuat_oleh')->nullable(); // admin_id
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('id')->on('users')->onDelete('set null');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumen');
    }
};
