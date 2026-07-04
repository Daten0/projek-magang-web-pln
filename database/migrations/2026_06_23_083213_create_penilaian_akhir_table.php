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

            // Hapus atau ganti baris nilai yang lama dengan 5 komponen baru ini:
            $table->unsignedTinyInteger('nilai_keterampilan_teknis')->nullable();
            $table->unsignedTinyInteger('nilai_pemecahan_masalah')->nullable();
            $table->unsignedTinyInteger('nilai_kedisiplinan')->nullable();
            $table->unsignedTinyInteger('nilai_kerjasama')->nullable();
            $table->unsignedTinyInteger('nilai_kehadiran')->nullable();

            $table->enum('status_kelulusan', ['Lulus', 'Tidak Lulus', 'Belum Dinilai'])
                  ->default('Belum Dinilai');

            $table->enum('status_performa', ['SANGAT BAIK', 'BAIK', 'CUKUP', 'BELUM DINILAI'])
                  ->default('BELUM DINILAI');

            
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