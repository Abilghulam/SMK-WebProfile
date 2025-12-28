<?php

namespace Database\Seeders;

use App\Models\LegalDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LegalDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $disk = 'public';
        $targetDir = 'legal_documents';

        // Pastikan folder target ada
        Storage::disk($disk)->makeDirectory($targetDir);

        $docs = [
            [
                'category' => 'legalitas',
                'title' => 'SK Pendirian Sekolah',
                'slug' => 'sk-pendirian-sekolah',
                'description' => 'Surat Keputusan pendirian sekolah sebagai dasar hukum operasional.',
                'source_public_path' => public_path('assets/files/sk-pendirian-sekolah.pdf'),
                'file_type' => 'pdf',
            ],
            [
                'category' => 'legalitas',
                'title' => 'Sertifikat Akreditasi Sekolah',
                'slug' => 'sertifikat-akreditasi-sekolah',
                'description' => 'Dokumen resmi status dan peringkat akreditasi sekolah.',
                'source_public_path' => public_path('assets/files/sertifikat-akreditasi.pdf'),
                'file_type' => 'pdf',
            ],
            [
                'category' => 'legalitas',
                'title' => 'Dokumen Kurikulum Sekolah',
                'slug' => 'dokumen-kurikulum-sekolah',
                'description' => 'Dokumen kurikulum yang digunakan dalam kegiatan pembelajaran.',
                'source_public_path' => public_path('assets/files/kurikulum-sekolah.pdf'),
                'file_type' => 'pdf',
            ],
            [
                'category' => 'template',
                'title' => 'Template Surat Keterangan Wali',
                'slug' => 'template-surat-keterangan-wali',
                'description' => 'Template surat keterangan wali untuk keperluan administrasi.',
                'source_public_path' => public_path('assets/files/template-surat-keterangan-wali.docx'),
                'file_type' => 'docx',
            ],
            [
                'category' => 'template',
                'title' => 'Template Surat Undangan Resmi',
                'slug' => 'template-surat-undangan-resmi',
                'description' => 'Template undangan resmi untuk kegiatan sekolah.',
                'source_public_path' => public_path('assets/files/template-surat-undangan.docx'),
                'file_type' => 'docx',
            ],
            [
                'category' => 'panduan',
                'title' => 'Alur Pengajuan Surat',
                'slug' => 'alur-pengajuan-surat',
                'description' => 'Panduan alur pengajuan surat menyurat di sekolah.',
                'source_public_path' => public_path('assets/files/alur-pengajuan-surat.pdf'),
                'file_type' => 'pdf',
            ],
        ];

        foreach ($docs as $d) {
            // Nama file target di storage
            $basename = basename($d['source_public_path']);
            $targetPath = $targetDir . '/' . $basename;

            // Copy file jika sumbernya ada
            if (file_exists($d['source_public_path'])) {
                // taruh ke storage/public/legal_documents/...
                Storage::disk($disk)->put($targetPath, file_get_contents($d['source_public_path']));
            } else {
                // kalau file sumber belum ada, tetap bikin record tapi file_path null
                $targetPath = null;
            }

            LegalDocument::updateOrCreate(
                ['slug' => $d['slug']],
                [
                    'category' => $d['category'],
                    'title' => $d['title'],
                    'description' => $d['description'],
                    'file_path' => $targetPath,   // penting: path relatif disk public
                    'external_url' => null,
                    'file_type' => $d['file_type'],
                    'file_size' => $targetPath ? (Storage::disk($disk)->size($targetPath) ?? null) : null,
                    'is_published' => true,
                    'published_at' => now(),
                ]
            );
        }
    }
}
