<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Landing Dokumentasi
     * URL: /dokumentasi
     * - tampilkan daftar album
     * - filter category via query string (?category=kegiatan)
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        $galleries = Gallery::query()
            ->published()
            ->withCount('items')
            ->withCount([
                'items as photos_count' => function ($q) {
                    $q->where('type', 'image');
                },
                'items as videos_count' => function ($q) {
                    $q->where('type', 'video');
                },
            ])
            ->with(['items' => function ($q) {
                $q->where('type', 'image')
                ->orderBy('sort_order')
                ->limit(1);
            }])
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        // Untuk filter UI (list kategori yang muncul)
        $categories = Gallery::query()
            ->published()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('layouts.user-pages.documentation.index', compact(
            'galleries',
            'category',
            'categories'
        ));
    }

    /**
     * Detail Album
     * URL: /dokumentasi/{slug}
     * - tampilkan 1 album + items (image only)
     */
    public function show(string $slug)
    {
        $gallery = Gallery::query()
            ->published()
            ->with(['items' => function ($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        // Untuk sidebar / navigasi: album lain (optional, ringan)
        $related = Gallery::query()
            ->published()
            ->where('id', '!=', $gallery->id)
            ->when($gallery->category, fn ($q) => $q->where('category', $gallery->category))
            ->orderByDesc('event_date')
            ->take(6)
            ->get();

        return view('layouts.user-pages.documentation.show', compact('gallery', 'related'));
    }
}
