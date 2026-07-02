<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilMentor extends Model
{
    protected $table = 'profil_mentor';

    protected $fillable = [
    'user_id',
    'nip',
    'nomor_telepon',
    'jabatan',
    'unit_kerja',
    'divisi',
    'status',
    'foto',  // tambah ini
];

    /**
     * User (akun login) milik mentor ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}