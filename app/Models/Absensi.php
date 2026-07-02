<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'peserta_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Absensi ini milik peserta siapa.
     */
    public function peserta()
    {
        return $this->belongsTo(ProfilPeserta::class, 'peserta_id');
    }
}