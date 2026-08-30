<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClimateStat extends Model
{
    protected $fillable = ['indicator', 'value', 'unit', 'subtitle', 'trend_type'];
}
