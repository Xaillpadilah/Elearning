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
        Schema::create('pertemuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id'); // relasi ke siswa
            $table->unsignedBigInteger('mapel_id'); // relasi ke mata pelajaran

            // jumlah pertemuan per semester
            $table->integer('pertemuan_semester1')->default(0);
            $table->integer('pertemuan_semester2')->default(0);

            // jumlah hadir per semester
            $table->integer('hadir_semester1')->default(0);
            $table->integer('hadir_semester2')->default(0);

            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuans');
    }
};
