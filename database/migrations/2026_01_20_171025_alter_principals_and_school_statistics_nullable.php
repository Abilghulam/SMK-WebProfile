<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // PRINCIPALS
        Schema::table('principals', function (Blueprint $table) {
            // jadikan nullable supaya firstOrCreate([]) aman
            $table->string('name', 255)->nullable()->change();

            // optional: position sudah ada default "Kepala Sekolah", tapi biar fleksibel:
            // kalau kamu mau tetap wajib, jangan diubah
            $table->string('position', 255)->nullable()->change();
        });

        // SCHOOL_STATISTICS
        Schema::table('school_statistics', function (Blueprint $table) {
            // kalau kamu mau "boleh kosong", ubah jadi nullable
            // (kalau kamu prefer default 0, sebenarnya nggak perlu diubah)
            $table->integer('total_students')->nullable()->change();
            $table->integer('total_teachers')->nullable()->change();
            $table->integer('total_departments')->nullable()->change();

            $table->string('academic_year', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        // rollback ke kondisi "wajib"
        Schema::table('principals', function (Blueprint $table) {
            $table->string('name', 255)->nullable(false)->change();
            $table->string('position', 255)->nullable(false)->default('Kepala Sekolah')->change();
        });

        Schema::table('school_statistics', function (Blueprint $table) {
            $table->integer('total_students')->nullable(false)->default(0)->change();
            $table->integer('total_teachers')->nullable(false)->default(0)->change();
            $table->integer('total_departments')->nullable(false)->default(0)->change();
            $table->string('academic_year', 20)->nullable()->change(); // aslinya sudah nullable di screenshot
        });
    }
};
