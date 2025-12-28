<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {

            // rename image -> cover_image
            if (Schema::hasColumn('galleries', 'image')) {
                $table->renameColumn('image', 'cover_image');
            }

            // kolom baru
            $table->string('slug')->unique()->after('title');
            $table->text('description')->nullable()->after('slug');
            $table->string('category')->nullable()->after('description');
            $table->date('event_date')->nullable()->after('category');
            $table->boolean('is_published')->default(true)->after('event_date');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->renameColumn('cover_image', 'image');

            $table->dropColumn([
                'slug',
                'description',
                'category',
                'event_date',
                'is_published',
            ]);
        });
    }
};
