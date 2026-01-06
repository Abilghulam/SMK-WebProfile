@extends('layouts.app')

@section('title', 'Blog | SMK Negeri 9 Muaro Jambi')
@section('meta_description', 'Berita, agenda, dan prestasi terbaru dari SMK Negeri 9 Muaro Jambi')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Blog',
        'title' => 'Blog Sekolah',
        'subtitle' => 'Berita, agenda, dan prestasi terbaru dari SMK Negeri 9 Muaro Jambi',
    ])

    {{-- FEATURED POST --}}
    @if (!empty($featured))
        <section class="page-section blog-featured">
            <div class="container">

                <a href="{{ route('blog.show', $featured->slug) }}"
                    class="featured-card {{ empty($featured->thumbnail_url) ? 'no-thumb' : '' }}">

                    <div class="featured-content">

                        <div class="featured-top">
                            <span class="featured-kicker">Pengumuman Resmi</span>
                        </div>

                        <h2 class="featured-title">{{ $featured->title }}</h2>

                        @if (!empty($featured->excerpt))
                            <p class="featured-excerpt">{{ $featured->excerpt }}</p>
                        @endif

                        <div class="featured-bottom">
                            <div class="featured-meta">
                                <span class="featured-date">
                                    {{ optional($featured->published_at)->format('d M Y') }}
                                </span>
                                <span class="featured-sep">|</span>
                                <span class="featured-cat">Blog Sekolah</span>
                            </div>

                            <span class="featured-cta">
                                Baca Pengumuman
                                <span style="margin-top: 7px;" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            </span>
                        </div>

                    </div>

                    @if (!empty($featured->thumbnail_url))
                        <div class="featured-thumb">
                            <img src="{{ asset($featured->thumbnail_url) }}" alt="{{ $featured->title }}" loading="lazy">
                        </div>
                    @endif

                </a>

            </div>
        </section>
    @endif


    <section class="page-section blog-landing">
        <div class="container">

            {{-- HIGHLIGHTS --}}
            <div class="blog-section-head">
                <h2 class="blog-h2">Sorotan Informasi Sekolah</h2>
                <p class="blog-sub">Ringkasan cepat dari berita, agenda, dan prestasi SMK Negeri 9 Muaro Jambi.</p>
            </div>

            <div class="blog-highlight-grid">

                {{-- Berita --}}
                <div class="blog-block">
                    <div class="blog-block-head">
                        <h3>Berita Sekolah</h3>
                        <a class="blog-link" href="{{ route('blog.news') }}">Lihat semua</a>
                    </div>

                    @forelse ($newsHighlights as $post)
                        @include('layouts.user-pages.blog.partials._card', ['post' => $post])
                    @empty
                        <p class="blog-empty">Belum ada berita.</p>
                    @endforelse
                </div>

                {{-- Agenda --}}
                <div class="blog-block">
                    <div class="blog-block-head">
                        <h3>Agenda Sekolah</h3>
                        <a class="blog-link" href="{{ route('blog.agenda') }}">Lihat semua</a>
                    </div>

                    @forelse ($agendaHighlights as $post)
                        @include('layouts.user-pages.blog.partials._card-agenda', ['post' => $post])
                    @empty
                        <p class="blog-empty">Belum ada agenda terdekat.</p>
                    @endforelse
                </div>

                {{-- Prestasi --}}
                <div class="blog-block">
                    <div class="blog-block-head">
                        <h3>Prestasi Sekolah</h3>
                        <a class="blog-link" href="{{ route('blog.achievements') }}">Lihat semua</a>
                    </div>

                    @forelse ($achievementHighlights as $post)
                        @include('layouts.user-pages.blog.partials._card-achievement', ['post' => $post])
                    @empty
                        <p class="blog-empty">Belum ada prestasi.</p>
                    @endforelse
                </div>

            </div>

            {{-- LATEST --}}
            <div class="blog-section-head blog-section-head--spaced">
                <h2 class="blog-h2">Blog Terbaru</h2>
                <p class="blog-sub">Update terbaru dari SMK Negeri 9 Muaro Jambi.</p>
            </div>

            <div class="blog-latest-grid">
                @forelse ($latest as $post)
                    @include('layouts.user-pages.blog.partials._card', ['post' => $post])
                @empty
                    <p class="blog-empty">Belum ada postingan.</p>
                @endforelse
            </div>

            <div class="usr-pagination">
                {{ $latest->links() }}
            </div>

        </div>
    </section>

@endsection
