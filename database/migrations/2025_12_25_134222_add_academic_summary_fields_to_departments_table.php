<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedTinyInteger('duration_years')->default(3)->after('career_opportunities');
            $table->string('learning_model')->nullable()->after('duration_years');
            $table->boolean('has_internship')->default(true)->after('learning_model');
            $table->json('learning_activities')->nullable()->after('has_internship');
            $table->string('graduate_profile')->nullable()->after('learning_activities');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn([
                'duration_years',
                'learning_model',
                'has_internship',
                'learning_activities',
                'graduate_profile',
            ]);
        });
    }
};
