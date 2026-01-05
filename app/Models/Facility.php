<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'category',     // indoor | outdoor
        'is_active',    // tampil / sembunyi
        'sort_order',   // urutan manual
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /* =========================
       CONSTANTS / OPTIONS
       ========================= */

    public const CATEGORY_OPTIONS = [
        'indoor' => 'Indoor',
        'outdoor' => 'Outdoor',
    ];

    /* =========================
       ACCESSORS
       ========================= */

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_OPTIONS[$this->category]
            ?? ucfirst($this->category ?? '');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/' . $this->image);
    }

    /* =========================
       SCOPES
       ========================= */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory($query, ?string $category)
    {
        if (!$category || $category === 'all') {
            return $query;
        }

        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }
}
