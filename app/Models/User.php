<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status_pendaftaran',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Relasi ke profil peserta (kalau role = peserta).
     */
    public function profilPeserta()
    {
        return $this->hasOne(ProfilPeserta::class);
    }

    /**
     * Relasi ke profil mentor (kalau role = mentor).
     */
    public function profilMentor()
    {
        return $this->hasOne(ProfilMentor::class);
    }

    /**
     * Daftar peserta yang dibimbing (kalau role = mentor).
     */
    public function pesertaBimbingan()
    {
        return $this->hasMany(ProfilPeserta::class, 'mentor_id');
    }

    /**
     * Helper cek role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }
}
