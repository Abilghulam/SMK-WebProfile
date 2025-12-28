<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    /**
     * Biasanya settings hanya 1 baris data,
     * jadi tidak perlu timestamps false (biarkan default)
     */

    protected $fillable = [
        // Identitas situs
        'site_name',
        'logo',
        'favicon',

        // Kontak
        'phone',
        'email',
        'address',

        // Sosial media
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'whatsapp_url',

        // Footer & maps
        'maps_embed',
        'footer_about',
        'copyright_text',
    ];

    /* ===============================
       HELPERS (opsional tapi rapi)
    ================================ */

    /**
     * Ambil 1 row setting (singleton pattern sederhana)
     */
    public static function current(): ?self
    {
        return static::first();
    }

    /**
     * Helper logo (fallback aman)
     */
    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset($this->logo)
            : asset('assets/images/logo.png');
    }

    /**
     * Helper favicon
     */
    public function getFaviconUrlAttribute(): string
    {
        return $this->favicon
            ? asset($this->favicon)
            : asset('assets/images/favicon.ico');
    }
}
