<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('ujians', function (Blueprint $table) {
            if (!Schema::hasColumn('ujians', 'mapel_id')) {
                $table->unsignedBigInteger('mapel_id')->nullable()->after('id');
                $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
            }

            if (!Schema::hasColumn('ujians', 'kelas_id')) {
                $table->unsignedBigInteger('kelas_id')->nullable()->after('mapel_id');
                $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('ujians', function (Blueprint $table) {
            if (Schema::hasColumn('ujians', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }

            if (Schema::hasColumn('ujians', 'mapel_id')) {
                $table->dropForeign(['mapel_id']);
                $table->dropColumn('mapel_id');
            }
        });
    }
};