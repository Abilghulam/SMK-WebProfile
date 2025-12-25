<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolStatisticSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('school_statistics')->insert([
            'total_students'    => 1200,
            'total_teachers'    => 80,
            'total_departments' => 6,
            'academic_year'     => '2025/2026',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
