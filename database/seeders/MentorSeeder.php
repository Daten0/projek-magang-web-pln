<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilMentor;

class MentorSeeder extends Seeder
{
    public function run(): void
    {
        $mentor = User::firstOrCreate(
    ['email' => 'mentor@pln.com'],
    [
        'name'               => 'Mentor PLN',
        'password'           => Hash::make('mentor123'),
        'role'               => 'mentor',
        'status_pendaftaran' => 'aktif',
    ]
);

ProfilMentor::firstOrCreate(
    ['user_id' => $mentor->id],
    [
        'nip'          => '19900101001',
        'nomor_telepon'=> '081234567890',
        'jabatan'      => 'Staff IT',
        'unit_kerja'   => 'PLN UP2D',
        'divisi'       => 'IT Development',
        'status'       => 'Aktif',
    ]
);
    }
}