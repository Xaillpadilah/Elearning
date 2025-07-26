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
       Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mapel_id');       // FK ke tabel mapels
            $table->unsignedBigInteger('kelas_id');       // FK ke tabel kelas
            $table->string('judul');                      // Judul materi
            $table->text('deskripsi')->nullable();        // Deskripsi opsional
            $table->string('tipe_konten');                // file, video, link
            $table->string('file_path')->nullable();      // Path file jika upload
            $table->string('link')->nullable();           // URL jika tipe = link
            $table->unsignedBigInteger('uploaded_by');    // FK ke users (admin/guru)
            $table->timestamps();                         // created_at & updated_at

            // Foreign Key constraints
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};