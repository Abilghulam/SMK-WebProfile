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

     protected $appends = ['abbr', 'cover_url'];

    public function getAbbrAttribute(): string
    {
        // 1) kalau suatu saat kamu punya kolom abbr sendiri, pakai itu
        if (!empty($this->attributes['abbr'] ?? null)) {
            return (string) $this->attributes['abbr'];
        }

        // 2) mapping cepat untuk nama populer (kamu bisa tambah)
        $name = (string) ($this->name ?? '');
        $map = [
            'Teknik Komputer dan Jaringan' => 'TKJ',
            'Teknik Sepeda Motor' => 'TSM',
            'Rekayasa Perangkat Lunak' => 'RPL',
            'Multimedia' => 'MM',
            'Akuntansi' => 'AKL',
            'Otomatisasi dan Tata Kelola Perkantoran' => 'OTKP',
            'Bisnis Daring dan Pemasaran' => 'BDP',
        ];

        foreach ($map as $k => $v) {
            if (Str::lower($name) === Str::lower($k)) return $v;
        }

        // 3) fallback: ambil huruf awal tiap kata (tanpa kata sambung)
        $stop = ['dan', 'dengan', 'ke', 'di', 'dari', 'untuk', 'pada', 'yang', '&'];
        $words = preg_split('/\s+/', Str::lower($name), -1, PREG_SPLIT_NO_EMPTY);

        $abbr = '';
        foreach ($words as $w) {
            $w = preg_replace('/[^a-z0-9]/', '', $w);
            if ($w === '' || in_array($w, $stop, true)) continue;
            $abbr .= strtoupper(substr($w, 0, 1));
        }

        return $abbr !== '' ? $abbr : 'DEP';
    }

    public function getCoverUrlAttribute(): ?string
    {
        $path = $this->image ?? null;
        if (!$path) return null;

        return asset('storage/' . ltrim($path, '/'));
    }
}
