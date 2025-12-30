<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_otps', function (Blueprint $table) {
            $table->timestamp('locked_until')->nullable()->after('attempts');
            $table->string('last_sent_ip', 45)->nullable()->after('locked_until');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_otps', function (Blueprint $table) {
            //
        });
    }
};
