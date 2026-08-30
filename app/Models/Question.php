<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'assessment_id', 'type', 'text', 'options', 'correct_answer', 'essay_guideline', 'is_ai'
    ];

    protected $casts = [
        'options' => 'array',
        'is_ai' => 'boolean'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
