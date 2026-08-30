<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    // Tambahkan 'cover_image' dan 'document_file' ke dalam array ini
    protected $fillable = [
        'title',
        'category',
        'order_number',
        'description',
        'cover_image',
        'document_file'
    ];

    // Relasi ke tabel user_progress (jika sudah ada sebelumnya)
    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }
}
