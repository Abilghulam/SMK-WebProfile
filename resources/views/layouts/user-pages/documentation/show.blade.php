@extends('layouts.app')

@php
    $desc = $gallery->description
        ? \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($gallery->description))), 155)
        : 'Dokumentasi kegiatan dan aktivitas sekolah.';
@endphp

@section('title', ($gallery->title ?? 'Dokumentasi') . ' | SMK Negeri 9 Muaro Jambi')
@section('meta_description', $desc)

@section('og_title', ($gallery->title ?? 'Dokumentasi') . ' | SMK Negeri 9 Muaro Jambi')
@section('og_description', $desc)
@section('og_image', $gallery->cover_url)
@section('og_type', 'article')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' =>
            'Album' .
            ($gallery->category
                ? ' ' . \Illuminate\Support\Str::title(str_replace('-', ' ', $gallery->category))
                : ''),
        'title' => $gallery->title ?? 'Album Dokumentasi',
        'subtitle' => $gallery->description ?? 'Dokumentasi kegiatan sekolah.',
        'bgImage' => !empty($gallery->cover_image) ? asset($gallery->cover_image) : null,
    ])

    <section class="page-section doc-detail">
        <div class="container">

            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="crumb-sep">/</span>
                <a href="{{ route('documentation.index') }}">Dokumentasi</a>
                <span class="crumb-sep">/</span>
                <span class="crumb-current">{{ \Illuminate\Support\Str::limit($gallery->title, 40) }}</span>
            </nav>

            <div class="doc-detail-grid">

                {{-- MAIN --}}
                <div class="doc-main">
                    <div class="doc-main-head">
                        <div class="doc-main-head-left">
                            <h2 class="doc-h2">{{ $gallery->title }}</h2>

                            <div class="doc-info-line">
                                @if (!empty($gallery->category))
                                    <span
                                        class="doc-tag">{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $gallery->category)) }}</span>
                                    <span class="dot">•</span>
                                @endif

                                <span class="doc-date">
                                    {{ optional($gallery->event_date)->format('d M Y') ?? optional($gallery->created_at)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if (!empty($gallery->description))
                        <div class="doc-desc-box">
                            <p>{{ $gallery->description }}</p>
                        </div>
                    @endif

                    @php
                        $toEmbedUrl = function (?string $url) {
                            if (!$url) {
                                return null;
                            }

                            // YouTube watch?v=
                            if (preg_match('~youtube\.com/watch\?v=([A-Za-z0-9_-]+)~', $url, $m)) {
                                return "https://www.youtube.com/embed/{$m[1]}";
                            }

                            // YouTube short youtu.be/
                            if (preg_match('~youtu\.be/([A-Za-z0-9_-]+)~', $url, $m)) {
                                return "https://www.youtube.com/embed/{$m[1]}";
                            }

                            // Already embed
                            if (str_contains($url, 'youtube.com/embed/')) {
                                return $url;
                            }

                            // Vimeo (basic)
                            if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) {
                                return "https://player.vimeo.com/video/{$m[1]}";
                            }

                            return null;
                        };
                    @endphp

                    {{-- Grid Photos --}}
                    <div class="doc-photos">
                        @forelse ($gallery->items as $index => $item)

                            @php
                                $type = $item->type ?? 'image';
                            @endphp

                            {{-- IMAGE --}}
                            @if ($type === 'image')
                                <button type="button" class="doc-photo doc-photo-btn" data-lb-src="{{ $item->url }}"
                                    data-lb-caption="{{ $item->caption ?? '' }}"
                                    data-lb-alt="{{ $item->caption ?? $gallery->title }}"
                                    data-lb-index="{{ $index }}" aria-label="Buka foto dokumentasi">
                                    <img src="{{ $item->url }}" alt="{{ $item->caption ?? $gallery->title }}"
                                        loading="lazy">

                                    <div class="doc-photo-overlay">
                                        <span class="doc-photo-icon">+</span>

                                        @if (!empty($item->caption))
                                            <span class="doc-caption">{{ $item->caption }}</span>
                                        @endif
                                    </div>
                                </button>
                            @endif

                            {{-- VIDEO --}}
                            @if ($type === 'video')
                                @php
                                    $embed = $toEmbedUrl($item->path);
                                @endphp

                                <button type="button" class="doc-video-card doc-video-btn"
                                    data-lb-video="{{ $embed }}"
                                    data-lb-caption="{{ $item->caption ?? $gallery->title }}"
                                    data-lb-index="{{ $index }}" aria-label="Buka video dokumentasi">

                                    <div class="doc-video-frame">
                                        @if ($embed)
                                            <iframe src="{{ $embed }}"
                                                title="{{ $item->caption ?? $gallery->title }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        @else
                                            <div class="doc-video-fallback">
                                                <div class="doc-video-fallback-badge">Video</div>
                                                <p>Link video belum valid.</p>
                                            </div>
                                        @endif

                                        @if (!empty($item->caption))
                                            <div class="doc-video-overlay">
                                                <span class="doc-video-overlay-caption">{{ $item->caption }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if (!empty($item->caption))
                                        <div class="doc-video-caption doc-video-caption--mobile">
                                            {{ $item->caption }}
                                        </div>
                                    @endif
                                </button>
                            @endif

                        @empty
                            <div class="doc-empty">
                                <h3>Belum ada dokumentasi</h3>
                                <p>Konten dokumentasi untuk album ini belum ditambahkan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- SIDE --}}
                @php
                    $photoCount = $gallery->items->where('type', 'image')->count();
                    $videoCount = $gallery->items->where('type', 'video')->count();
                @endphp

                <aside class="doc-side">

                    <div class="side-card">
                        <div class="side-head">
                            <h3>Informasi Album</h3>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Judul</div>
                            <div class="side-value">{{ $gallery->title }}</div>
                        </div>

                        @if (!empty($gallery->category))
                            <div class="side-row">
                                <div class="side-label">Kategori</div>
                                <div class="side-value">
                                    {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $gallery->category)) }}
                                </div>
                            </div>
                        @endif

                        <div class="side-row">
                            <div class="side-label">Tanggal</div>
                            <div class="side-value">
                                {{ optional($gallery->event_date)->format('d M Y') ?? optional($gallery->created_at)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Slug</div>
                            <div class="side-value mono">{{ $gallery->slug }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Jumlah Foto</div>
                            <div class="side-value">{{ $photoCount }}</div>
                        </div>

                        @if ($videoCount > 0)
                            <div class="side-row">
                                <div class="side-label">Jumlah Video</div>
                                <div class="side-value">{{ $videoCount }}</div>
                            </div>
                        @endif

                    </div>

                    @if (!empty($related) && $related->count())
                        <div class="side-card side-card--actions">
                            <h3>Album Lainnya</h3>

                            <div class="doc-related">
                                @foreach ($related as $g)
                                    <a class="doc-related-item" href="{{ route('documentation.show', $g->slug) }}">
                                        <span
                                            class="doc-related-title">{{ \Illuminate\Support\Str::limit($g->title, 52) }}</span>
                                        <span class="doc-related-arrow" aria-hidden="true">→</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="side-card side-card--actions">
                        <h3>Aksi Cepat</h3>

                        <a class="side-action" href="{{ route('documentation.index') }}">
                            Kembali ke Album Dokumentasi
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>


                </aside>

            </div>
        </div>
    </section>

    {{-- LIGHTBOX MODAL --}}
    <div class="lb" id="lb" aria-hidden="true">
        <div class="lb-backdrop" data-lb-close></div>

        <div class="lb-dialog" role="dialog" aria-modal="true" aria-label="Pratinjau gambar">
            <button class="lb-close" type="button" aria-label="Tutup" data-lb-close>×</button>

            <button class="lb-nav lb-prev" type="button" aria-label="Sebelumnya" data-lb-prev>‹</button>
            <button class="lb-nav lb-next" type="button" aria-label="Berikutnya" data-lb-next>›</button>

            <figure class="lb-figure">
                <div class="lb-media" id="lbMedia">
                    <img class="lb-img" id="lbImg" alt="">
                    <div class="lb-video" id="lbVideo" hidden>
                        <iframe id="lbIframe" src="" frameborder="0"
                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <figcaption class="lb-cap" id="lbCap"></figcaption>
            </figure>
        </div>
    </div>

    {{-- DATASET LIGHTBOX --}}
    <script>
        window.__GALLERY_ITEMS__ = [
            @foreach ($gallery->items as $item)
                @php $type = $item->type ?? 'image'; @endphp

                @if ($type === 'image')
                    {
                        type: "image",
                        src: "{{ asset($item->path) }}",
                        caption: @json($item->caption ?? ''),
                        alt: @json($item->caption ?? $gallery->title),
                    },
                @elseif ($type === 'video')
                    @php $embed = $toEmbedUrl($item->path); @endphp {
                        type: "video",
                        video: @json($embed), // embed url
                        caption: @json($item->caption ?? $gallery->title),
                        alt: @json($item->caption ?? $gallery->title),
                    },
                @endif
            @endforeach
        ];
    </script>

@endsection
