<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'title',
        'module_id',
        'type',
        'duration_minutes',
        'passing_grade',
        'max_attempts',
        'shuffle_questions',
        'start_time',
        'end_time'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
