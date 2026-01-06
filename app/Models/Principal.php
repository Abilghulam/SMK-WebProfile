<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Principal extends Model
{
    protected $fillable = [
        'name',
        'position',
        'welcome_message',
        'photo',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) return null;
        return asset('storage/' . $this->photo);
    }

}
