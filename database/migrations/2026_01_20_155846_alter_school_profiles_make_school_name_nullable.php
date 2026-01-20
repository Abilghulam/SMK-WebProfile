<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            // sebelumnya NOT NULL -> jadi nullable
            $table->string('school_name', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            // balik ke NOT NULL (pastikan tidak ada NULL dulu sebelum rollback)
            $table->string('school_name', 255)->nullable(false)->change();
        });
    }
};
