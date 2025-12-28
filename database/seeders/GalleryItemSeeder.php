<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryItem;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Ambil 1 gallery pertama
         * (atau sesuaikan kalau mau spesifik berdasarkan slug / title)
         */
        $gallery = Gallery::first();

        if (!$gallery) {
            $this->command->warn('Gallery belum ada. Seeder GalleryItem dilewati.');
            return;
        }

        /**
         * Cek apakah video ini sudah pernah ada
         * supaya tidak dobel
         */
        $videoUrl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

        $exists = GalleryItem::where('gallery_id', $gallery->id)
            ->where('type', 'video')
            ->where('path', $videoUrl)
            ->exists();

        if ($exists) {
            $this->command->info('Video dokumentasi sudah ada, tidak ditambahkan ulang.');
            return;
        }

        /**
         * Tambahkan video (tanpa menyentuh item image)
         */
        GalleryItem::create([
            'gallery_id' => $gallery->id,
            'type'       => 'video',
            'path'       => $videoUrl,
            'caption'    => 'Video dokumentasi kegiatan sekolah',
            'sort_order' => 999,
        ]);

        $this->command->info('Video dokumentasi berhasil ditambahkan.');
    }
}
