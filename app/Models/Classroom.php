<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject', 'description', 'code', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_user');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
