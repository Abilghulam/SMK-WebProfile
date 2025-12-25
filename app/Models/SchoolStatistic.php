<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolStatistic extends Model
{
    protected $table = 'school_statistics';

    protected $fillable = [
        'total_students',
        'total_teachers',
        'total_departments',
        'academic_year',
    ];  
}
