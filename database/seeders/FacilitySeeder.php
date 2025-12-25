<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer dengan perangkat yang memadai untuk mendukung pembelajaran teknologi informasi dan praktik pemrograman.',
                'image' => 'assets/images/facilities/lab-komputer.jpg',
            ],
            [
                'name' => 'Perpustakaan Sekolah',
                'description' => 'Perpustakaan dengan koleksi buku pelajaran, referensi, dan literatur pendukung pembelajaran siswa.',
                'image' => 'assets/images/facilities/perpustakaan.jpg',
            ],
            [
                'name' => 'Workshop / Bengkel Praktik',
                'description' => 'Bengkel praktik yang dilengkapi peralatan sesuai standar industri untuk mendukung pembelajaran berbasis praktik.',
                'image' => 'assets/images/facilities/bengkel.jpg',
            ],
            [
                'name' => 'Lapangan Olahraga',
                'description' => 'Fasilitas lapangan olahraga untuk mendukung kegiatan olahraga, upacara, dan aktivitas ekstrakurikuler.',
                'image' => 'assets/images/facilities/lapangan.jpg',
            ],
            [
                'name' => 'Ruang Kelas',
                'description' => 'Ruang kelas yang nyaman dan kondusif untuk kegiatan belajar mengajar.',
                'image' => 'assets/images/facilities/kelas.jpg',
            ],
            [
                'name' => 'Ruang UKS',
                'description' => 'Ruang Unit Kesehatan Sekolah untuk pelayanan kesehatan siswa.',
                'image' => 'assets/images/facilities/uks.jpg',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
