<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianAkhir extends Model
{
    protected $table = 'penilaian_akhir';

    protected $fillable = [
        'peserta_id',
        'mentor_id',
        'nilai_kehadiran',
        'nilai_logbook',
        'nilai_laporan_akhir',
        'nilai_sikap',
        'nilai_akhir',
        'status_kelulusan',
        'catatan',
        'dinilai_pada',
    ];

    protected $casts = [
        'dinilai_pada' => 'datetime',
    ];

    /**
     * Penilaian ini milik peserta siapa.
     */
    public function peserta()
    {
        return $this->belongsTo(ProfilPeserta::class, 'peserta_id');
    }

    /**
     * Mentor yang memberikan penilaian.
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}