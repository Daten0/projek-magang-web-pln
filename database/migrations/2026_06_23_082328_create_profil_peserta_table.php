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
        Schema::create('profil_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('mentor_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('nim')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('instansi')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('divisi')->nullable();
            $table->enum('jenis_pendaftaran', ['Praktik Industri', 'KKN', 'Magang Mandiri'])->nullable();

            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();

            $table->text('alasan_ditolak')->nullable();

            $table->enum('status_magang', ['Aktif', 'Selesai', 'Bermasalah', 'Menunggu Penilaian'])
                  ->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_peserta');
    }
};