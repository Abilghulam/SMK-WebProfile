<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
