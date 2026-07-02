<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'peserta_id',
        'nomor_sertifikat',
        'file_path',
        'status',
        'diterbitkan_oleh',
        'diterbitkan_pada',
    ];

    protected $casts = [
        'diterbitkan_pada' => 'datetime',
    ];

    /**
     * Sertifikat ini milik peserta siapa.
     */
    public function peserta()
    {
        return $this->belongsTo(ProfilPeserta::class, 'peserta_id');
    }

    /**
     * Admin yang menerbitkan sertifikat ini.
     */
    public function penerbit()
    {
        return $this->belongsTo(User::class, 'diterbitkan_oleh');
    }
}