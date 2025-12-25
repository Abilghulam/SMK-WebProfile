<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([
            [
                'title' => 'Profil Sekolah',
                'slug'  => 'profil-sekolah',
                'content' => '<p>Ini adalah halaman profil sekolah.</p>',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Akademik',
                'slug'  => 'akademik',
                'content' => '<p>Informasi akademik sekolah.</p>',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
