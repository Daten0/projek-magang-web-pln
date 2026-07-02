<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbook';

    protected $fillable = [
        'peserta_id',
        'tanggal',
        'tanggal_kegiatan',
        'jam_kegiatan',
        'judul_aktivitas',
        'deskripsi',
        'dokumentasi',
        'status',
        'catatan_mentor',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'tanggal'           => 'date',
        'diverifikasi_pada' => 'datetime',
    ];

    /**
     * Logbook ini milik peserta siapa.
     */
    public function peserta()
    {
        return $this->belongsTo(ProfilPeserta::class, 'peserta_id');
    }

    /**
     * Mentor yang memverifikasi logbook ini.
     */
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}