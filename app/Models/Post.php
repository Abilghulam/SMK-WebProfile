<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Post extends Model
{
    public const TYPE_LABELS = [
        'news'        => 'Berita',
        'agenda'      => 'Agenda',
        'achievement' => 'Prestasi',
        'event'       => 'Kegiatan',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? ucfirst($this->type);
    }

    protected $table = 'posts';

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'is_published',
        'is_featured',
        'published_at',
        'event_start_at',
        'event_end_at',
        'location',
        'level',
        'awarded_at',
    ];

    protected $casts = [
        'is_published'   => 'boolean',
        'is_featured'    => 'boolean',
        'published_at'   => 'datetime',
        'event_start_at' => 'datetime',
        'event_end_at'   => 'datetime',
        'awarded_at'     => 'date',
    ];

    /**
     * Auto-generate slug dari title (kalau slug kosong).
     */
    protected static function booted()
    {
        static::creating(function ($post) {
            if (empty($post->slug) && !empty($post->title)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /* ===============================
       SCOPES (biar query controller bersih)
    ================================ */

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNotFeatured($query)
    {
        return $query->where('is_featured', false);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

}
