<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianAkhir extends Model
{
    protected $table = 'penilaian_akhir';

    // Sesuaikan array fillable dengan struktur 5 komponen baru
    protected $fillable = [
        'peserta_id',
        'mentor_id',
        'nilai_keterampilan_teknis',
        'nilai_pemecahan_masalah',
        'nilai_kedisiplinan',
        'nilai_kerjasama',
        'nilai_kehadiran',
        'nilai_akhir',
        'status_kelulusan',
        'status_performa',
        'catatan',
        'dinilai_pada',
    ];

    protected $casts = [
        'nilai_keterampilan_teknis' => 'integer',
        'nilai_pemecahan_masalah'   => 'integer',
        'nilai_kedisiplinan'        => 'integer',
        'nilai_kerjasama'           => 'integer',
        'nilai_kehadiran'           => 'integer',
        'nilai_akhir'               => 'integer',
        'dinilai_pada'              => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(ProfilPeserta::class, 'peserta_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}