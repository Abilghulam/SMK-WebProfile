<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('instagram_url')->nullable()->after('email');
            $table->string('facebook_url')->nullable()->after('instagram_url');
            $table->string('tiktok_url')->nullable()->after('facebook_url');
            $table->string('whatsapp_url')->nullable()->after('tiktok_url');

            $table->text('maps_embed')->nullable()->after('address');
            $table->text('footer_about')->nullable()->after('maps_embed');
            $table->string('copyright_text')->nullable()->after('footer_about');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'instagram_url',
                'facebook_url',
                'tiktok_url',
                'whatsapp_url',
                'maps_embed',
                'footer_about',
                'copyright_text',
            ]);
        });
    }
};
