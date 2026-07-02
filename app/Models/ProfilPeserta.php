<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPeserta extends Model
{
    protected $table = 'profil_peserta';

    protected $fillable = [
        'user_id',
        'mentor_id',
        'nim',
        'nomor_telepon',
        'instansi',
        'jurusan',
        'divisi',
        'jenis_pendaftaran',
        'periode_mulai',
        'periode_selesai',
        'alasan_ditolak',
        'status_magang',
        'foto',
    ];

    protected $casts = [
        'periode_mulai'   => 'date',
        'periode_selesai' => 'date',
    ];

    /**
     * User (akun login) milik peserta ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke profil mentor (via profil_mentor.id).
     * Digunakan untuk ambil nama mentor di halaman profil peserta.
     */
    public function profilMentor()
    {
        return $this->belongsTo(ProfilMentor::class, 'mentor_id');
    }

    /**
     * Riwayat absensi peserta ini.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'peserta_id');
    }

    /**
     * Riwayat logbook peserta ini.
     */
    public function logbook()
    {
        return $this->hasMany(Logbook::class, 'peserta_id');
    }

    /**
     * Laporan akhir peserta ini (1 peserta = 1 laporan).
     */
    public function laporanAkhir()
    {
        return $this->hasOne(LaporanAkhir::class, 'peserta_id');
    }

    /**
     * Penilaian akhir peserta ini (1 peserta = 1 penilaian).
     */
    public function penilaianAkhir()
    {
        return $this->hasOne(PenilaianAkhir::class, 'peserta_id');
    }

    /**
     * Sertifikat peserta ini (1 peserta = 1 sertifikat).
     */
    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'peserta_id');
    }
}