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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->unique()->constrained('profil_peserta')->onDelete('cascade');

            $table->string('nomor_sertifikat')->unique();
            $table->string('file_path')->nullable();

            $table->enum('status', ['Belum Terbit', 'Terbit'])->default('Belum Terbit');

            $table->foreignId('diterbitkan_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('diterbitkan_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};