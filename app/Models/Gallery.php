<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'cover_image',
        'event_date',
        'is_published',
    ];

    protected $casts = [
        'event_date'    => 'date',
        'is_published'  => 'boolean',
    ];

    /* ===============================
       RELATIONSHIPS
    ================================ */

    public function items()
    {
        return $this->hasMany(GalleryItem::class)->orderBy('sort_order');
    }

    /* ===============================
       SCOPES (opsional, tapi berguna)
    ================================ */

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeCategory($query, ?string $category)
    {
        if (!$category) return $query;
        return $query->where('category', $category);
    }

    /* ===============================
       SLUG GENERATION
    ================================ */

    protected static function booted()
    {
        static::creating(function ($gallery) {
            if (empty($gallery->slug) && !empty($gallery->title)) {
                $base = Str::slug($gallery->title);
                $slug = $base;

                $i = 2;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i;
                    $i++;
                }

                $gallery->slug = $slug;
            }
        });
    }

    /* =====================
    FALLBACK COVER OTOMATIS
    ======================== */
    public function getCoverUrlAttribute(): string
    {
        // 1) kalau cover_image ada, pakai itu
        if (!empty($this->cover_image)) {
            return asset($this->cover_image);
        }

        // 2) fallback: ambil item image pertama (kalau relasi sudah diload)
        if ($this->relationLoaded('items')) {
            $firstImage = $this->items->firstWhere('type', 'image');
            if ($firstImage && !empty($firstImage->path)) {
                return asset($firstImage->path);
            }
        }

        // 3) fallback terakhir
        return asset('assets/images/placeholder.png');
    }


}
