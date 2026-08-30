<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name', 'email', 'password', 'avatar', 'role',
    'nik', 'npwp', 'tempat_lahir', 'tanggal_lahir', 'agama', 'kewarganegaraan', 'jenis_kelamin', 'no_hp',
    'universitas', 'dosen_pa', 'nim', 'jenis_pendaftaran', 'prodi', 'jalur_pendaftaran', 'ukt', 'angkatan',
    'gelombang_masuk', 'status_akademik', 'tanggal_masuk', 'periode_masuk', 'kelas',
    'jalan', 'dusun', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kab_kota', 'provinsi', 'kode_pos', 'penerima_kps',
    'nama_ayah', 'no_hp_ayah', 'alamat_ayah', 'nama_ibu', 'no_hp_ibu', 'alamat_ibu',
    'nama_wali', 'no_hp_wali', 'pt_asal', 'prodi_asal', 'riwayat_pendidikan_terakhir','kode_kelas', 'foto','nama_panggilan', 'otp_code', 'email_verified_at', 'otp_code', 'otp_expires_at'
];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ==========================================
    // HELPER METHODS (PENGECEKAN ROLE)
    // ==========================================
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // ==========================================
    // RELASI DATABASE
    // ==========================================

    // Relasi ke Progress Belajar
    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    // Relasi ke Achievement / Pencapaian
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')->withTimestamps();
    }

    // Relasi ke Riwayat Pengerjaan Kuis / Ujian
    public function studentAttempts(): HasMany
    {
        return $this->hasMany(StudentAttempt::class);
    }

    // ==========================================
    // ALIAS RELASI UNTUK FITUR CETAK RAPOR
    // ==========================================

    public function userProgresses(): HasMany
    {
        // Mengarah ke model UserProgress
        return $this->hasMany(UserProgress::class, 'user_id');
    }

    public function examAttempts(): HasMany
    {
        // Mengarah ke model StudentAttempt (karena ini yang Anda pakai untuk ujian/kuis)
        return $this->hasMany(StudentAttempt::class, 'user_id');
    }

    // Kelas yang diikuti mahasiswa
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user');
    }


    // Tambahkan fungsi ini di dalam class User
    public function addXP($amount, $activityName = 'Aktivitas Belajar')
    {
        $this->xp += $amount;

        // Cek apakah XP cukup untuk NAIK LEVEL
        $xpNeededForNextLevel = $this->level * 1000;

        if ($this->xp >= $xpNeededForNextLevel) {
            $this->level += 1;
            // Opsional: Anda bisa menyimpan pesan "Selamat Naik Level!" di Session Flash
            session()->flash('level_up', '🎉 SELAMAT! Kamu naik ke Level ' . $this->level . '!');
        }

        $this->save();
    }

    /**
     * Hitung total XP yang dibutuhkan untuk mencapai level tertentu.
     * Rumus: Semakin tinggi level, XP yang dibutuhkan naik secara eksponensial.
     */
    public static function calculateXpForLevel($level)
    {
        if ($level <= 1) return 0;
        // Rumus RPG: (Level-1) * 100 + (Level-1)^2 * 15
        // Contoh: Lv 2 butuh 115 XP, Lv 10 butuh 2.115 XP, Lv 100 butuh 156.915 XP
        return (($level - 1) * 100) + (pow($level - 1, 2) * 15);
    }

    /**
     * Dapatkan Nama Pangkat (Rank) berdasarkan Tema Lingkungan/Fisika
     */
    public function getRankNameAttribute()
    {
        $level = $this->level ?? 1;

        if ($level < 10) return '🌱 Eco Seedling';
        if ($level < 20) return '🌿 Green Learner';
        if ($level < 30) return '🌳 Earth Guardian';
        if ($level < 40) return '⚡ Energy Saver';
        if ($level < 50) return '♻️ Recycling Master';
        if ($level < 60) return '🌍 Climate Defender';
        if ($level < 70) return '💡 Eco Innovator';
        if ($level < 80) return '🔬 Tech for Earth';
        if ($level < 90) return '🚀 Eco Visionary';
        if ($level < 100) return '👑 Master of Sustainability';

        return '🌟 SMART-ECO Legend'; // Level 100
    }

    /**
     * Cek XP yang dibutuhkan untuk naik ke level selanjutnya
     */
    public function getNextLevelXpAttribute()
    {
        return self::calculateXpForLevel($this->level + 1);
    }



}
