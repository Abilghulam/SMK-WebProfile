<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Tipe konten: news | agenda | achievement
            $table->string('type', 30)->default('news')->after('id')->index();

            // Agenda fields
            $table->dateTime('event_start_at')->nullable()->after('published_at')->index();
            $table->dateTime('event_end_at')->nullable()->after('event_start_at');
            $table->string('location')->nullable()->after('event_end_at');

            // Achievement fields
            $table->string('level', 50)->nullable()->after('location')->index();
            $table->date('awarded_at')->nullable()->after('level')->index();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'event_start_at',
                'event_end_at',
                'location',
                'level',
                'awarded_at',
            ]);
        });
    }
};
