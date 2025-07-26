<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            if (!Schema::hasColumn('materis', 'tipe_konten')) {
                $table->string('tipe_konten')->after('deskripsi');
            }
            if (!Schema::hasColumn('materis', 'file_path')) {
                $table->string('file_path')->nullable()->after('tipe_konten');
            }
            if (!Schema::hasColumn('materis', 'link')) {
                $table->string('link')->nullable()->after('file_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropColumn(['tipe_konten', 'file_path', 'link']);
        });
    }
};
