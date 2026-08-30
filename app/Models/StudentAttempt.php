<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttempt extends Model
{
    protected $fillable = [
        'user_id', 'assessment_id', 'attempt_number',
        'total_score', 'is_completed', 'is_passed',
        'started_at', 'completed_at'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
