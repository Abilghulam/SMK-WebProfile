<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            'site_name' => 'SMK Negeri Contoh',
            'logo'      => 'img/logo.png',
            'favicon'   => 'img/favicon.ico',
            'phone'     => '021-123456',
            'email'     => 'info@smkcontoh.sch.id',
            'address'   => 'Jl. Pendidikan No. 1, Indonesia',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}
