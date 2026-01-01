<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\LegalDocument;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\Department;
use App\Models\Facility;

class DashboardController extends Controller
{
    public function index()
    {
        // BLOG
        $postsTotal     = Post::count();
        $postsPublished = Post::where('is_published', 1)->count();
        $postsDraft     = $postsTotal - $postsPublished;

        // LEGAL DOCS
        $legalTotal       = LegalDocument::count();
        $legalPublished   = LegalDocument::where('is_published', 1)->count();
        $legalDownloads   = (int) LegalDocument::sum('download_count');

        // DOKUMENTASI
        $albumsTotal = Gallery::count();
        $itemsTotal  = GalleryItem::count();
        $photoTotal  = GalleryItem::where('type', 'image')->count();
        $videoTotal  = GalleryItem::where('type', 'video')->count();

        // AKADEMIK
        $deptTotal   = Department::count();
        $deptActive  = Department::where('is_active', 1)->count();
        $facTotal    = Facility::count();

        $stats = [
            'blog' => [
                'value' => $postsTotal,
                'meta'  => "{$postsPublished} Publish | {$postsDraft} Draft",
            ],
            'legal' => [
                'value' => $legalTotal,
                'meta'  => "{$legalPublished} Publish | {$legalDownloads} Unduhan",
            ],
            'docs' => [
                'value' => $albumsTotal,
                'meta'  => "{$itemsTotal} Item | {$photoTotal} Foto | {$videoTotal} Video",
            ],
            'acad' => [
                'value' => $deptTotal,
                'meta'  => "{$deptActive} Program Keahlian | {$facTotal} Fasilitas",
            ],
        ];

        return view('layouts.admin-pages.dashboard', compact('stats'));
    }
}
