@extends('layouts.app')

@section('title', 'Blog | SMK Negeri')
@section('meta_description', 'Berita, agenda, dan prestasi terbaru dari SMK Negeri')

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
                    class="featured-card {{ empty($featured->thumbnail) ? 'no-thumb' : '' }}">

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
                                <span aria-hidden="true">→</span>
                            </span>
                        </div>

                    </div>

                    @if (!empty($featured->thumbnail))
                        <div class="featured-thumb">
                            <img src="{{ asset($featured->thumbnail) }}" alt="{{ $featured->title }}" loading="lazy">
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

            <div class="blog-pagination">
                {{ $latest->links() }}
            </div>

        </div>
    </section>

@endsection
