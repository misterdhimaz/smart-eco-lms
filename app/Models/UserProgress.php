<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    protected $fillable = ['user_id', 'module_id', 'progress_percentage', 'status'];

    // Relasi balik ke tabel users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi balik ke tabel modules (Ini yang dicari oleh Laravel)
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
