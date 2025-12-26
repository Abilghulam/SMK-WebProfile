<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Landing page /blog
     * - Highlight: news terbaru, agenda upcoming, prestasi terbaru
     * - Latest: campuran semua tipe
     */
    public function index()
    {
        $featured = Post::published()
            ->type('news')
            ->featured()
            ->orderByDesc('published_at')
            ->first();

        $newsHighlights = Post::published()
            ->type('news')
            ->notFeatured()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $agendaHighlights = Post::published()
            ->type('agenda')
            ->whereNotNull('event_start_at')
            ->where('event_start_at', '>=', now())
            ->orderBy('event_start_at')
            ->take(3)
            ->get();

        $achievementHighlights = Post::published()
            ->type('achievement')
            ->orderByDesc('awarded_at')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $latest = Post::published()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('layouts.user-pages.blog.index', compact(
            'featured',
            'newsHighlights',
            'agendaHighlights',
            'achievementHighlights',
            'latest'
        ));
    }

    public function news()
    {
        $posts = Post::published()
            ->type('news')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('layouts.user-pages.blog.news', compact('posts'));
    }

    public function agenda()
    {
        $upcoming = Post::published()
            ->type('agenda')
            ->whereNotNull('event_start_at')
            ->where('event_start_at', '>=', now())
            ->orderBy('event_start_at')
            ->paginate(10, ['*'], 'upcoming_page');

        $past = Post::published()
            ->type('agenda')
            ->whereNotNull('event_start_at')
            ->where('event_start_at', '<', now())
            ->orderByDesc('event_start_at')
            ->paginate(10, ['*'], 'past_page');

        return view('layouts.user-pages.blog.agenda', compact('upcoming', 'past'));
    }

    public function achievements()
    {
        $posts = Post::published()
            ->type('achievement')
            ->orderByDesc('awarded_at')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('layouts.user-pages.blog.achievements', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('layouts.user-pages.blog.show', compact('post'));
    }
}
