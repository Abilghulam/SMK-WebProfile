<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'competencies',
        'career_opportunities',
        'duration_years',
        'learning_model',
        'has_internship',
        'learning_activities',
        'graduate_profile',
        'image',
        'is_active',
    ];

    protected $casts = [
    'competencies' => 'array',
    'career_opportunities' => 'array',
    'learning_activities' => 'array',
    'has_internship' => 'boolean',
    'is_active' => 'boolean',
    ];


    /**
     * Otomatis generate slug dari name
     */
    protected static function booted()
    {
        static::creating(function ($department) {
            if (empty($department->slug)) {
                $department->slug = Str::slug($department->name);
            }
        });

        static::updating(function ($department) {
            if ($department->isDirty('name')) {
                $department->slug = Str::slug($department->name);
            }
        });
    }
}
