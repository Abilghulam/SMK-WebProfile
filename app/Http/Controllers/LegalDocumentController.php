<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    public function index()
    {
        // Group sesuai kategori yang kita sepakati
        $docs = LegalDocument::published()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('category');

        return view('layouts.user-pages.services.legalitas', compact('docs'));
    }

    public function show(string $slug)
    {
        $doc = LegalDocument::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('layouts.user-pages.services.legalitas-show', compact('doc'));
    }

    public function download(string $slug)
    {
        $doc = LegalDocument::published()->where('slug', $slug)->firstOrFail();

        // Lokal (storage/app/public)
        if (!empty($doc->file_path)) {
            $disk = 'public';

            if (!Storage::disk($disk)->exists($doc->file_path)) {
                return back()->with('error', 'File dokumen tidak ditemukan. Silakan hubungi admin.');
            }

            $doc->increment('download_count');

            $ext = $doc->file_type ?: pathinfo($doc->file_path, PATHINFO_EXTENSION) ?: 'pdf';
            $filename = ($doc->slug ?: 'dokumen') . '.' . $ext;

            return Storage::disk($disk)->download($doc->file_path, $filename);
        }

        // External
        if (!empty($doc->external_url)) {
            $doc->increment('download_count');
            return redirect()->away($doc->external_url);
        }

        return back()->with('error', 'Dokumen belum tersedia untuk diunduh.');
    }


}
