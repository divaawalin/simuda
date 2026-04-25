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
         Schema::table('users', function (Blueprint $table) {
             $table->string('desa')->nullable()->after('alamat');
             $table->string('kelompok')->nullable()->after('desa');
             $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('kelompok');
             // status column already exists as enum('aktif','tidak_aktif')
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['desa', 'kelompok', 'jenis_kelamin']);
         });
     }
};
