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
        'image',
        'is_active',
    ];

    protected $casts = [
    'competencies' => 'array',
    'career_opportunities' => 'array',
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
