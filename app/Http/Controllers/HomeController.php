<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use App\Models\SchoolStatistic;
use App\Models\Principal;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.user-pages.home', [
            'schoolProfile' => SchoolProfile::first(),
            'statistic'     => SchoolStatistic::first(),
            'principal'     => Principal::first(),

            'latestGalleries' => Gallery::query()
                ->published()
                ->withCount([
                    'items as photos_count' => function ($q) {
                        $q->where('type', 'image');
                    },
                    'items as videos_count' => function ($q) {
                        $q->where('type', 'video');
                    },
                ])
                ->with(['items' => function ($q) {
                    $q->where('type', 'image')->orderBy('sort_order')->limit(1);
                }])
                ->orderByDesc('event_date')
                ->orderByDesc('created_at')
                ->take(6)
                ->get(),
        ]);
    }
}
