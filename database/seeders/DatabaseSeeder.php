<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            SchoolProfileSeeder::class,
            SchoolStatisticSeeder::class,
            PrincipalSeeder::class,
            PageSeeder::class,
            DepartmentSeeder::class,
            FacilitySeeder::class,
            PostSeeder::class,
            GallerySeeder::class,
            GalleryItemSeeder::class,
            LegalDocumentSeeder::class,
        ]);
    }

}
