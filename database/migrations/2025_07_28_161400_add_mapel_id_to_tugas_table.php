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
           Schema::table('tugas', function (Blueprint $table) {
        $table->unsignedBigInteger('mapel_id')->after('id')->nullable();

        // Pastikan tabel `mapels` sudah ada
        $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('tugas', function (Blueprint $table) {
        $table->dropForeign(['mapel_id']);
        $table->dropColumn('mapel_id');
    });
}
};
