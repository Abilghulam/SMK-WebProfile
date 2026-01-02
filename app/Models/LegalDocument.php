<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LegalDocument extends Model
{
    protected $table = 'legal_documents';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'file_path',
        'external_url',
        'download_count',
        'file_type',
        'file_size',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'download_count' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'file_size' => 'integer',
    ];

        public const CATEGORY_LABELS = [
        'legalitas' => 'Legalitas',
        'template' => 'Template',
        'administrasi' => 'Administrasi',
        'panduan' => 'Panduan',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_LABELS[$this->category] ?? ucfirst($this->category);
    }

    protected static function booted()
    {
        static::creating(function ($doc) {
            if (empty($doc->slug) && !empty($doc->title)) {
                $doc->slug = Str::slug($doc->title);
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // Helper: ambil link download yang dipakai
    public function getDownloadUrlAttribute(): ?string
    {
        if (!empty($this->external_url)) return $this->external_url;
        if (!empty($this->file_path)) return asset('storage/' . $this->file_path);
        return null;
    }

    public function categoryLabel(): string
    {
        return $this->category
            ? Str::of($this->category)->replace('_', ' ')->title()
            : '—';
    }
}
