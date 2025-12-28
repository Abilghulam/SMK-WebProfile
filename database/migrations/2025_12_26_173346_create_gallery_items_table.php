<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gallery_id')
                ->constrained('galleries')
                ->cascadeOnDelete();

            // Siap untuk video nanti, tapi sekarang pakai image dulu
            $table->string('type')->default('image'); // image | video

            // Path file (mis: uploads/galleries/xxx.jpg)
            $table->string('path');

            // Keterangan opsional (caption)
            $table->string('caption')->nullable();

            // Untuk urutan tampil
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            // Index tambahan biar query cepat
            $table->index(['gallery_id', 'type']);
            $table->index(['gallery_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
