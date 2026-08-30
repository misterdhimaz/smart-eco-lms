<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $fillable = ['badge', 'title', 'description', 'cover_image'];

    public function videos()
    {
        return $this->hasMany(Video::class, 'video_category_id')->orderBy('order', 'asc');
    }
}
