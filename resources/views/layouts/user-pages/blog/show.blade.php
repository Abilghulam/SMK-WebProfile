@extends('layouts.app')

@section('title', ($post->title ?? 'Detail Blog') . ' | SMK Negeri')
@section('meta_description', $post->excerpt ?? 'Informasi terbaru dari sekolah')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => $post->type ?? 'Blog',
        'title' => $post->title ?? 'Detail',
        'subtitle' => $post->excerpt ?? 'Informasi dan publikasi sekolah.',
        'bgImage' => $post->thumbnail ? asset($post->thumbnail) : null,
    ])

    <section class="page-section blog-show">
        <div class="container">

            {{-- Breadcrumb --}}
            <nav class="blog-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="blog-crumb-sep">/</span>
                <a href="{{ route('blog.index') }}">Blog</a>

                @if ($post->type === 'news')
                    <span class="blog-crumb-sep">/</span>
                    <a href="{{ route('blog.news') }}">Berita</a>
                @elseif($post->type === 'agenda')
                    <span class="blog-crumb-sep">/</span>
                    <a href="{{ route('blog.agenda') }}">Agenda</a>
                @elseif($post->type === 'achievement')
                    <span class="blog-crumb-sep">/</span>
                    <a href="{{ route('blog.achievements') }}">Prestasi</a>
                @endif

                <span class="blog-crumb-sep">/</span>
                <span class="blog-crumb-current">{{ \Illuminate\Support\Str::limit($post->title, 34) }}</span>
            </nav>

            <div class="blog-show-grid">

                {{-- MAIN --}}
                <article class="blog-article">

                    {{-- Cover (optional, kalau thumbnail ada) --}}
                    @if (!empty($post->thumbnail))
                        <div class="blog-cover">
                            <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" loading="lazy">
                        </div>
                    @endif

                    <div class="blog-article-card">
                        <div class="blog-article-meta">
                            <span class="blog-type-pill blog-type-pill--{{ $post->type }}">
                                {{ $post->type === 'news' ? 'Berita' : ($post->type === 'agenda' ? 'Agenda' : 'Prestasi') }}
                            </span>

                            <span class="blog-meta-sep">|</span>

                            <span class="blog-meta-date">
                                {{ optional($post->published_at)->format('d M Y') ?? '-' }}
                            </span>
                        </div>

                        <h1 class="blog-article-title">{{ $post->title }}</h1>

                        @if (!empty($post->excerpt))
                            <p class="blog-article-excerpt">{{ $post->excerpt }}</p>
                        @endif

                        <div class="blog-divider"></div>

                        <div class="blog-content">
                            {!! $post->content !!}
                        </div>

                    </div>

                </article>

                {{-- SIDE PANEL --}}
                <aside class="blog-side">

                    <div class="side-card">
                        <div class="side-head">
                            <h3>Informasi</h3>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Kategori</div>
                            <div class="side-value">
                                {{ $post->type === 'news' ? 'Berita Sekolah' : ($post->type === 'agenda' ? 'Agenda Sekolah' : 'Prestasi') }}
                            </div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Dipublikasikan</div>
                            <div class="side-value">
                                {{ optional($post->published_at)->format('d M Y') ?? '-' }}
                            </div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Slug</div>
                            <div class="side-value mono">{{ $post->slug }}</div>
                        </div>
                    </div>

                    {{-- Agenda Meta --}}
                    @if ($post->type === 'agenda')
                        <div class="side-card side-card--summary">
                            <h3>Detail Agenda</h3>

                            <div class="side-row">
                                <div class="side-label">Mulai</div>
                                <div class="side-value">
                                    {{ optional($post->event_start_at)->format('d M Y, H:i') ?? '-' }}
                                </div>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Selesai</div>
                                <div class="side-value">
                                    {{ optional($post->event_end_at)->format('d M Y, H:i') ?? '-' }}
                                </div>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Lokasi</div>
                                <div class="side-value">
                                    {{ $post->location ?? '-' }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Achievement Meta --}}
                    @if ($post->type === 'achievement')
                        <div class="side-card side-card--summary">
                            <h3>Detail Prestasi</h3>

                            <div class="side-row">
                                <div class="side-label">Level</div>
                                <div class="side-value">
                                    {{ $post->level ?? '-' }}
                                </div>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Tanggal</div>
                                <div class="side-value">
                                    {{ optional($post->awarded_at)->format('d M Y') ?? '-' }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Aksi Cepat --}}
                    <div class="side-card side-card--actions">
                        <h3>Aksi Cepat</h3>

                        <a class="side-action" href="{{ route('blog.index') }}">
                            Kembali ke Blog
                            <span aria-hidden="true">→</span>
                        </a>

                        @if ($post->type === 'news')
                            <a class="side-action" href="{{ route('blog.news') }}">
                                Semua Berita
                                <span aria-hidden="true">→</span>
                            </a>
                        @elseif($post->type === 'agenda')
                            <a class="side-action" href="{{ route('blog.agenda') }}">
                                Semua Agenda
                                <span aria-hidden="true">→</span>
                            </a>
                        @elseif($post->type === 'achievement')
                            <a class="side-action" href="{{ route('blog.achievements') }}">
                                Semua Prestasi
                                <span aria-hidden="true">→</span>
                            </a>
                        @endif
                    </div>

                </aside>

            </div>
        </div>
    </section>

@endsection
