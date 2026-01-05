<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // status tampil/sembunyi
            $table->boolean('is_active')->default(true)->after('image');

            // kategori sederhana (dropdown): indoor | outdoor
            $table->string('category', 50)->nullable()->after('is_active');

            // urutan tampil manual
            $table->unsignedInteger('sort_order')->default(0)->after('category');

            // index untuk performa list/filter
            $table->index(['is_active', 'category', 'sort_order'], 'facilities_active_cat_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropIndex('facilities_active_cat_sort_idx');
            $table->dropColumn(['is_active', 'category', 'sort_order']);
        });
    }
};
