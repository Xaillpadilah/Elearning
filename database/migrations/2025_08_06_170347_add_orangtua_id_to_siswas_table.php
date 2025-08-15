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
        if (!Schema::hasColumn('siswas', 'orangtua_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->unsignedBigInteger('orangtua_id')->nullable()->after('kelas_id');
                $table->foreign('orangtua_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Hapus kolom 'orangtua_id' jika dibatalkan (rollback)
     */
    public function down(): void
    {
        if (Schema::hasColumn('siswas', 'orangtua_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->dropForeign(['orangtua_id']);
                $table->dropColumn('orangtua_id');
            });
        }
    }
};
