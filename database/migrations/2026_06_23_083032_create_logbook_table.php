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
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('profil_peserta')->onDelete('cascade');

            $table->date('tanggal');
            $table->string('judul_aktivitas');
            $table->text('deskripsi');

            $table->enum('status', ['Menunggu Verifikasi', 'Disetujui', 'Perlu Revisi'])
                  ->default('Menunggu Verifikasi');

            $table->text('catatan_mentor')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('diverifikasi_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};