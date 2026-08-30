<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $fillable = [
        'badge', 'title', 'description', 'cover_image', 'type', 'embed_url'
    ];
}
