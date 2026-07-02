<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    protected $table = 'laporan_akhir';

    protected $fillable = [
        'peserta_id',
        'file_path',
        'nama_file_asli',
        'status',
        'catatan_mentor',
        'diunggah_pada',
        'diperiksa_oleh',
        'diperiksa_pada',
    ];

    protected $casts = [
        'diunggah_pada'  => 'datetime',
        'diperiksa_pada' => 'datetime',
    ];

    /**
     * Laporan ini milik peserta siapa.
     */
    public function peserta()
    {
        return $this->belongsTo(ProfilPeserta::class, 'peserta_id');
    }

    /**
     * Mentor yang memeriksa laporan ini.
     */
    public function pemeriksa()
    {
        return $this->belongsTo(User::class, 'diperiksa_oleh');
    }
}