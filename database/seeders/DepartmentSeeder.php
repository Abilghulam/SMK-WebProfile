<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Rekayasa Perangkat Lunak',
                'short_description' => 'Mempelajari pengembangan aplikasi dan sistem perangkat lunak.',
                'description' => 'Program keahlian Rekayasa Perangkat Lunak membekali peserta didik ...',
                'image' => 'assets/images/departments/rpl.jpg',
                'competencies' => [
                    'Pemrograman Web',
                    'Pemrograman Mobile',
                    'Basis Data',
                    'UI/UX Dasar',
                    'Version Control (Git)'
                ],
                'career_opportunities' => [
                    'Junior Web Developer',
                    'Mobile App Developer (Entry Level)',
                    'Quality Assurance (QA) Tester',
                    'IT Support / Helpdesk',
                    'Freelance Developer'
                ],
            ],
            [
                'name' => 'Teknik Komputer dan Jaringan',
                'short_description' => 'Fokus pada jaringan komputer dan infrastruktur IT.',
                'description' => 'Program keahlian Teknik Komputer dan Jaringan mempelajari perakitan komputer, instalasi jaringan, administrasi server, serta keamanan jaringan.',
                'image' => 'assets/images/departments/tkj.jpg',
                'competencies' => [
                    'Crimping Kabel Jaringan',
                    'Konfigurasi Router dan Switch',
                    'Administrasi Jaringan',
                    'Keamanan Jaringan Dasar',
                    'Troubleshooting Jaringan'
                ],
                'career_opportunities' => [
                    'Junior Network Administrator',
                    'Network Support Technician',
                    'IT Support / Helpdesk',
                    'Freelance Network Developer',
                    'Teknisi Jaringan'
                ],
            ],
            [
                'name' => 'Desain Komunikasi Visual',
                'short_description' => 'Mengembangkan kreativitas di bidang desain dan multimedia.',
                'description' => 'Program keahlian Desain Komunikasi Visual membekali siswa dengan keterampilan desain grafis, fotografi, videografi, dan komunikasi visual berbasis digital.',
                'image' => 'assets/images/departments/dkv.jpeg',
                'competencies' => [
                    'Desain Grafis',
                    'Fotografi',
                    'Videografi',
                    'Komunikasi Visual',
                    'Adobe Creative Suite'
                ],
                'career_opportunities' => [
                    'Junior Graphic Designer',
                    'Multimedia Designer',
                    'Content Creator',
                    'Social Media Designer',
                    'Freelance Designer'
                ],
            ],
        ];

        foreach ($departments as $item) {
            Department::create([
                'name'                 => $item['name'],
                'slug'                 => Str::slug($item['name']),
                'short_description'    => $item['short_description'],
                'description'          => $item['description'],
                'image'                => $item['image'],
                'competencies'         => $item['competencies'] ?? null,
                'career_opportunities' => $item['career_opportunities'] ?? null,
                'is_active'            => true,
            ]);
        }
    }
}
