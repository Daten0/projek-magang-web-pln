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
        Schema::create('laporan_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->unique()->constrained('profil_peserta')->onDelete('cascade');

            $table->string('file_path');
            $table->string('nama_file_asli');

            $table->enum('status', ['Belum Ada', 'Review', 'Diterima', 'Revisi'])
                  ->default('Review');

            $table->text('catatan_mentor')->nullable();
            $table->timestamp('diunggah_pada');
            $table->foreignId('diperiksa_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('diperiksa_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_akhir');
    }
};