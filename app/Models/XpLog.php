<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'title', 'xp'];
}
