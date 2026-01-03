<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    protected $table = 'gallery_items';

    protected $fillable = [
        'gallery_id',
        'type',
        'path',
        'caption',
        'sort_order',
    ];

    /* ===============================
       RELATIONSHIPS
    ================================ */

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';

    public function getUrlAttribute(): string
    {
        $path = ltrim((string) $this->path, '/');

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // kalau sudah storage/..., biarkan
        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        // default: diasumsikan storage/app/public/{path}
        return asset('storage/' . $path);
    }

}
