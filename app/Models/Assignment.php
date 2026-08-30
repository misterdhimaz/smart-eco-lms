<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['classroom_id', 'title', 'description', 'attachment', 'due_date'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
