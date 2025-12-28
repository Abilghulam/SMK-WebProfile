<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title'       => 'Dokumentasi Kegiatan MPLS',
                'description' => 'Kegiatan Masa Pengenalan Lingkungan Sekolah bagi peserta didik baru.',
                'category'    => 'kegiatan',
                'event_date'  => now()->subDays(30),
            ],
            [
                'title'       => 'Praktik Kejuruan Siswa',
                'description' => 'Dokumentasi kegiatan praktik kejuruan siswa di laboratorium sekolah.',
                'category'    => 'kegiatan',
                'event_date'  => now()->subDays(20),
            ],
            [
                'title'       => 'Prestasi Siswa Tingkat Provinsi',
                'description' => 'Dokumentasi prestasi siswa dalam berbagai perlombaan tingkat provinsi.',
                'category'    => 'prestasi',
                'event_date'  => now()->subDays(15),
            ],
            [
                'title'       => 'Fasilitas Laboratorium Sekolah',
                'description' => 'Dokumentasi fasilitas laboratorium dan ruang praktik sekolah.',
                'category'    => 'fasilitas',
                'event_date'  => now()->subDays(10),
            ],
        ];

        foreach ($galleries as $data) {
            Gallery::create([
                'title'        => $data['title'],
                'slug'         => Str::slug($data['title']),
                'description'  => $data['description'],
                'category'     => $data['category'],
                'cover_image'  => 'assets/images/placeholder.png',
                'event_date'   => $data['event_date'],
                'is_published' => true,
            ]);
        }
    }
}
