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
        Schema::create('penilaian_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->unique()->constrained('profil_peserta')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');

            $table->unsignedTinyInteger('nilai_kehadiran')->nullable();
            $table->unsignedTinyInteger('nilai_logbook')->nullable();
            $table->unsignedTinyInteger('nilai_laporan_akhir')->nullable();
            $table->unsignedTinyInteger('nilai_sikap')->nullable();
            $table->unsignedTinyInteger('nilai_akhir')->nullable();

            $table->enum('status_kelulusan', ['Lulus', 'Tidak Lulus', 'Belum Dinilai'])
                  ->default('Belum Dinilai');

            $table->text('catatan')->nullable();
            $table->timestamp('dinilai_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_akhir');
    }
};