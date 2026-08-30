<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoModule extends Model
{
    protected $fillable = ['badge', 'title', 'description', 'cover_image'];

    public function videos()
    {
        return $this->hasMany(Video::class, 'video_module_id')->orderBy('order', 'asc');
    }
}
