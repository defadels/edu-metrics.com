<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'nim',
        'program_study'
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

    public const PROGRAM_STUDIES = [
        'Agroteknologi',
        'Akuntansi dan Agribisnis',
        'Ilmu Pemerintahan',
        'Ilmu Keperawatan',
        'Matematika',
        'Pendidikan Geografi',
        'Pendidikan Bahasa Inggris',
        'Pendidikan Bahasa dan Sastra Indonesia',
        'Pendidikan IPS',
        'Teknik Informatika',
        'Sistem Informasi',
    ];

    public const ROLES = [
        'admin' => 'Administrator',
        'mahasiswa' => 'Mahasiswa',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function createdSurveys(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Survey::class, 'created_by');
    }

    public function responses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Response::class, 'user_id');
    }
}
