<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryBenchmark extends Model
{
    protected $fillable = [
        'role_title', 'seniority_level', 'location',
        'p25', 'p50', 'p75',
    ];
}
