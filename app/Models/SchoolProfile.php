<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional kalau sesuai konvensi)
     */
    protected $table = 'school_profiles';

    /**
     * Field yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'school_name',
        'slogan',
        'short_description',
        'history',
        'vision',
        'mission',
        'npsn',
        'accreditation',
        'curriculum',
        'logo',
        'address',
        'youtube_url'
    ];
}
