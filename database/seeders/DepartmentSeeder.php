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
                'description' => 'Program keahlian Rekayasa Perangkat Lunak membekali peserta didik dengan kompetensi di bidang pemrograman, pengembangan aplikasi web dan mobile, serta pengelolaan sistem perangkat lunak.',
                'image' => 'assets/images/departments/rpl.jpg',
                'competencies' => [
                    'Pemrograman Web',
                    'Pemrograman Mobile',
                    'Basis Data',
                    'UI/UX Dasar',
                    'Version Control (Git)',
                ],
                'career_opportunities' => [
                    'Junior Web Developer',
                    'Mobile Developer (Entry Level)',
                    'Quality Assurance (QA) Tester',
                    'IT Support / Helpdesk',
                    'Freelance Developer',
                ],

                // === NEW FIELDS ===
                'duration_years' => 3,
                'learning_model' => 'Teori & Praktik',
                'has_internship' => true,
                'learning_activities' => [
                    'Proyek & Portofolio',
                    'Praktik Industri (PKL)',
                    'Kunjungan Industri',
                ],
                'graduate_profile' => 'Siap kerja, siap berwirausaha, dan siap melanjutkan studi.',
            ],
            [
                'name' => 'Teknik Komputer dan Jaringan',
                'short_description' => 'Fokus pada jaringan komputer dan infrastruktur IT.',
                'description' => 'Program keahlian Teknik Komputer dan Jaringan mempelajari perakitan komputer, instalasi jaringan, administrasi server, dan dasar keamanan jaringan.',
                'image' => 'assets/images/departments/tkj.jpg',
                'competencies' => [
                    'Perakitan Komputer',
                    'Instalasi & Konfigurasi Jaringan',
                    'Administrasi Server',
                    'Keamanan Jaringan Dasar',
                ],
                'career_opportunities' => [
                    'Network Technician',
                    'IT Support',
                    'Junior Network Administrator',
                    'Helpdesk Technician',
                ],

                // === NEW FIELDS ===
                'duration_years' => 3,
                'learning_model' => 'Teori & Praktik',
                'has_internship' => true,
                'learning_activities' => [
                    'Praktik Jaringan',
                    'Simulasi Troubleshooting',
                    'Praktik Industri (PKL)',
                ],
                'graduate_profile' => 'Siap bekerja di bidang jaringan dan dukungan infrastruktur TI.',
            ],
            [
                'name' => 'Desain Komunikasi Visual',
                'short_description' => 'Mengembangkan kreativitas di bidang desain dan multimedia.',
                'description' => 'Program keahlian Desain Komunikasi Visual membekali siswa dengan keterampilan desain grafis, fotografi, videografi, dan komunikasi visual berbasis digital.',
                'image' => 'assets/images/departments/dkv.jpg',
                'competencies' => [
                    'Desain Grafis',
                    'Fotografi',
                    'Videografi',
                    'Komunikasi Visual',
                    'Adobe Creative Suite',
                ],
                'career_opportunities' => [
                    'Junior Graphic Designer',
                    'Multimedia Designer',
                    'Content Creator',
                    'Social Media Designer',
                    'Freelance Designer',
                ],

                // === NEW FIELDS ===
                'duration_years' => 3,
                'learning_model' => 'Teori & Praktik',
                'has_internship' => true,
                'learning_activities' => [
                    'Proyek Desain & Portofolio',
                    'Produksi Konten Multimedia',
                    'Praktik Industri (PKL)',
                ],
                'graduate_profile' => 'Siap berkarya di industri kreatif dan melanjutkan studi.',
            ],
        ];

        foreach ($departments as $item) {
            $slug = Str::slug($item['name']);

            Department::updateOrCreate(
                ['slug' => $slug],  // kunci unik
                [
                    'name' => $item['name'],
                    'short_description' => $item['short_description'] ?? null,
                    'description' => $item['description'] ?? null,
                    'image' => $item['image'] ?? null,

                    'competencies' => $item['competencies'] ?? null,
                    'career_opportunities' => $item['career_opportunities'] ?? null,

                    'duration_years' => $item['duration_years'] ?? 3,
                    'learning_model' => $item['learning_model'] ?? null,
                    'has_internship' => $item['has_internship'] ?? true,
                    'learning_activities' => $item['learning_activities'] ?? null,
                    'graduate_profile' => $item['graduate_profile'] ?? null,

                    'is_active' => true,
                ]
            );
        }
    }
}
