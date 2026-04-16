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
        Schema::create('absensi_sesi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->enum('tipe_sesi', ['mulai', 'selesai']);
            $table->enum('metode', ['mandiri', 'qr_code']);
            $table->enum('status_sesi', ['belum_mulai', 'berlangsung', 'selesai'])->default('belum_mulai');
            $table->string('qr_token')->nullable();
            $table->timestamp('qr_expires_at')->nullable();
            $table->foreignId('dimulai_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('dimulai_at')->nullable();
            $table->foreignId('diselesaikan_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('diselesaikan_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_sesi');
    }
};
