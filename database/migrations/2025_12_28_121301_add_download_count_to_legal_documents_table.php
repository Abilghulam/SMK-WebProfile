<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            $table->unsignedInteger('download_count')->default(0)->after('external_url'); 
            // sesuaikan "after(...)" kalau kolommu beda
        });
    }

    public function down(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            $table->dropColumn('download_count');
        });
    }
};
