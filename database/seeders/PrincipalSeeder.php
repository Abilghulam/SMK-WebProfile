<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrincipalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('principals')->insert([
            'name'            => 'Drs. Ahmad Sudirman',
            'position'        => 'Kepala Sekolah',
            'welcome_message' => 'Puji syukur ke hadirat Tuhan Yang Maha Esa, kami menyambut baik kehadiran website resmi sekolah.',
            'photo'           => 'assets/images/principal.jpg',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
