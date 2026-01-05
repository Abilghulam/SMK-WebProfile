@extends('layouts.app')

@php
    $metaCat = !empty($category) ? ' - ' . \Illuminate\Support\Str::title(str_replace('-', ' ', $category)) : '';
@endphp

@section('title', 'Dokumentasi' . $metaCat . ' | SMK Negeri 9 Muaro Jambi')
@section('meta_description',
    'Dokumentasi kegiatan, prestasi, fasilitas, dan aktivitas terbaru SMK Negeri 9 Muaro Jambi' .
    ($metaCat
    ? '
    (' .
    trim($metaCat, ' -') .
    ').'
    : '.'))


@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Dokumentasi',
        'title' => 'Dokumentasi Sekolah',
        'subtitle' => 'Galeri kegiatan, prestasi, dan aktivitas SMK Negeri 9 Muaro Jambi.',
    ])

    <section class="page-section doc-landing">
        <div class="container">

            <div class="section-header section-header--left">
                <h2>Album Dokumentasi</h2>
                <p>
                    Pilih album untuk melihat dokumentasi foto dan video kegiatan sekolah
                </p>
            </div>

            {{-- Filter --}}
            <div class="doc-filter">
                <a class="doc-chip {{ empty($category) ? 'active' : '' }}" href="{{ route('documentation.index') }}">
                    Semua
                </a>

                @foreach ($categories as $cat)
                    <a class="doc-chip {{ $category === $cat ? 'active' : '' }}"
                        href="{{ route('documentation.index', ['category' => $cat]) }}">
                        {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $cat)) }}
                    </a>
                @endforeach
            </div>

            {{-- Grid Album --}}
            <div class="doc-grid">
                @forelse ($galleries as $gallery)
                    <a class="doc-card" href="{{ route('documentation.show', $gallery->slug) }}">

                        <div class="doc-cover">
                            <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" loading="lazy">

                            @if (!empty($gallery->category))
                                <span class="doc-badge">
                                    {{ \Illuminate\Support\Str::upper($gallery->category) }}
                                </span>
                            @endif
                        </div>

                        <div class="doc-body">
                            <h3 class="doc-title">{{ $gallery->title }}</h3>

                            @if (!empty($gallery->description))
                                <p class="doc-desc">{{ \Illuminate\Support\Str::limit($gallery->description, 90) }}</p>
                            @endif

                            <div class="doc-meta">
                                <span class="doc-date">
                                    {{ optional($gallery->event_date)->format('d M Y') ?? optional($gallery->created_at)->format('d M Y') }}
                                </span>

                                <span class="doc-meta-sep">|</span>

                                <span class="doc-count">
                                    {{ $gallery->photos_count ?? 0 }} Foto
                                </span>

                                @if (!empty($gallery->videos_count))
                                    <span class="doc-meta-sep">|</span>
                                    <span class="doc-count">
                                        {{ $gallery->videos_count }} Video
                                    </span>
                                @endif

                                <span class="doc-meta-sep">|</span>

                                <span class="doc-more">Lihat album</span>
                            </div>
                        </div>

                    </a>
                @empty
                    <div class="doc-empty">
                        <h3>Belum ada dokumentasi</h3>
                        <p>Album dokumentasi akan ditampilkan di sini setelah dipublikasikan.</p>
                        <a class="doc-back" href="{{ url('/') }}">Kembali ke Home</a>
                    </div>
                @endforelse
            </div>

            <div class="doc-pagination">
                {{ $galleries->links() }}
            </div>

        </div>
    </section>

@endsection
