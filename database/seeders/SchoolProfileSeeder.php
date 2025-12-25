<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('school_profiles')->insert([
            'school_name'       => 'SMK Negeri Contoh',
            'slogan'            => 'Unggul, Berkarakter, Berprestasi',
            'short_description' => 'SMK Negeri Contoh adalah sekolah kejuruan yang berfokus pada kompetensi dan karakter.',
            'history'           => 'SMK Negeri Contoh berdiri sejak tahun 2005 sebagai pusat pendidikan vokasi.',
            'vision'            => 'Menjadi SMK unggulan yang menghasilkan lulusan berdaya saing global.',
            'mission'           => "Menyelenggarakan pendidikan berkualitas\nMengembangkan karakter siswa\nMenjalin kemitraan industri",
            'npsn'              => '12345678',
            'accreditation'     => 'A',
            'curriculum'        => 'Kurikulum Merdeka',
            'logo'              => 'img/logo.png',
            'address'           => 'Jl. Pendidikan No. 1, Indonesia',
            'youtube_url'       => 'https://youtube.com',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
