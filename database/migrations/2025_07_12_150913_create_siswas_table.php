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
     Schema::create('siswas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('nama');
        $table->string('email')->nullable(); 
        $table->string('nisn')->unique();
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->unsignedBigInteger('kelas_id');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
    });

    }

    public function down(): void {
        Schema::dropIfExists('siswas');
    }
};