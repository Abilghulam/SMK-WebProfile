<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [

            /* =========================
               BERITA SEKOLAH
            ========================= */
            [
                'type' => 'news',
                'title' => 'SMK Negeri Menggelar Kegiatan Pengenalan Lingkungan Sekolah',
                'excerpt' => 'Kegiatan MPLS dilaksanakan untuk menyambut peserta didik baru tahun ajaran terbaru.',
                'content' => '<p>SMK Negeri melaksanakan kegiatan Masa Pengenalan Lingkungan Sekolah (MPLS) sebagai bagian dari proses adaptasi peserta didik baru terhadap lingkungan sekolah.</p><p>Kegiatan ini bertujuan untuk memperkenalkan budaya sekolah, tata tertib, serta program pembelajaran.</p>',
                'thumbnail' => 'assets/images/blog/news-1.jpg',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'type' => 'news',
                'title' => 'SMK Negeri Raih Juara Lomba Inovasi Tingkat Kabupaten',
                'excerpt' => 'Prestasi membanggakan diraih oleh siswa SMK Negeri dalam ajang lomba inovasi.',
                'content' => '<p>Siswa SMK Negeri berhasil meraih juara dalam lomba inovasi tingkat kabupaten berkat karya kreatif dan inovatif.</p>',
                'thumbnail' => 'assets/images/blog/news-2.jpg',
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'type' => 'news',
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026 Dibuka',
                'excerpt' => 'Informasi resmi pelaksanaan PPDB SMK Negeri 9 Muaro Jambi.',
                'content' => '<p>Informasi lengkap PPDB SMK Negeri 9 Muaro Jambi tahun 2025.</p>',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(15),
            ],

            /* =========================
               AGENDA SEKOLAH
            ========================= */
            [
                'type' => 'agenda',
                'title' => 'Upacara Bendera Hari Senin',
                'excerpt' => 'Upacara bendera rutin yang diikuti seluruh warga sekolah.',
                'content' => '<p>Upacara bendera dilaksanakan sebagai bentuk penanaman nilai disiplin dan nasionalisme.</p>',
                'event_start_at' => Carbon::now()->addDays(3)->setTime(7, 0),
                'event_end_at' => Carbon::now()->addDays(3)->setTime(8, 0),
                'location' => 'Lapangan Upacara SMK Negeri',
                'published_at' => Carbon::now(),
            ],
            [
                'type' => 'agenda',
                'title' => 'Rapat Orang Tua/Wali Siswa',
                'excerpt' => 'Rapat pembahasan program sekolah bersama orang tua/wali siswa.',
                'content' => '<p>Rapat ini bertujuan untuk menyampaikan program sekolah dan menjalin komunikasi antara sekolah dan orang tua.</p>',
                'event_start_at' => Carbon::now()->addDays(14)->setTime(9, 0),
                'event_end_at' => Carbon::now()->addDays(14)->setTime(11, 0),
                'location' => 'Aula SMK Negeri',
                'published_at' => Carbon::now(),
            ],

            /* =========================
               PRESTASI SEKOLAH
            ========================= */
            [
                'type' => 'achievement',
                'title' => 'Juara 1 Lomba Desain Grafis Tingkat Provinsi',
                'excerpt' => 'Siswa SMK Negeri meraih juara pertama lomba desain grafis tingkat provinsi.',
                'content' => '<p>Prestasi ini diraih berkat kerja keras siswa dan bimbingan guru pembimbing.</p>',
                'level' => 'Provinsi',
                'awarded_at' => Carbon::now()->subMonths(2),
                'published_at' => Carbon::now()->subMonths(2),
            ],
            [
                'type' => 'achievement',
                'title' => 'Finalis Lomba Karya Tulis Ilmiah Nasional',
                'excerpt' => 'Siswa SMK Negeri berhasil menjadi finalis lomba karya tulis ilmiah tingkat nasional.',
                'content' => '<p>Keberhasilan ini menjadi bukti kemampuan akademik siswa SMK Negeri.</p>',
                'level' => 'Nasional',
                'awarded_at' => Carbon::now()->subMonths(5),
                'published_at' => Carbon::now()->subMonths(5),
            ],
        ];

        foreach ($posts as $item) {
            Post::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'type' => $item['type'],
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'thumbnail' => $item['thumbnail'] ?? null,
                    'published_at' => $item['published_at'],
                    'event_start_at' => $item['event_start_at'] ?? null,
                    'event_end_at' => $item['event_end_at'] ?? null,
                    'location' => $item['location'] ?? null,
                    'level' => $item['level'] ?? null,
                    'awarded_at' => $item['awarded_at'] ?? null,
                    'is_published' => true,
                ]
            );
        }
    }
}
