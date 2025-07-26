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
       Schema::table('penilaians', function (Blueprint $table) {
    $table->float('nilai_tugas')->default(0)->change();
    $table->float('nilai_kuis')->default(0)->change();
    $table->float('nilai_uts')->default(0)->change();
    $table->float('nilai_uas')->default(0)->change();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
