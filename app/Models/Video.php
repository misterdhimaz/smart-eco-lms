<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'video_module_id',
        'title',
        'type',
        'video_url',
        'duration',
        'description',
        'order'
    ];

    public function module()
    {
        return $this->belongsTo(VideoModule::class, 'video_module_id');
    }
}
