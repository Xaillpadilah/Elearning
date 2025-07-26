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
       Schema::create('orangtuas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nomor_hp');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('siswa_id');

        $table->timestamps();

        // Foreign keys
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('orangtuas');
    }
};