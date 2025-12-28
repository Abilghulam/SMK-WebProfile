<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();

            // Publik/umum
            $table->string('title');
            $table->string('slug')->unique();

            // Kategori: legalitas / template / administrasi (kamu bisa tambah)
            $table->string('category')->default('legalitas')->index();

            // Deskripsi singkat
            $table->text('description')->nullable();

            // File (sementara string)
            // contoh: "storage/legal/ppdb-2025.pdf" atau "assets/files/xxx.pdf"
            $table->string('file_path')->nullable();

            // Kalau kamu mau link eksternal (Google Drive, dsb)
            $table->string('external_url')->nullable();

            // Metadata
            $table->string('file_type', 30)->nullable(); // pdf/docx/xlsx/png
            $table->unsignedBigInteger('file_size')->nullable(); // bytes

            // Publish control
            $table->boolean('is_published')->default(true)->index();
            $table->dateTime('published_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
