@extends('layouts.app')

@section('title', 'Prestasi Sekolah | SMK Negeri')
@section('meta_description', 'Prestasi siswa dan sekolah SMK Negeri')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Blog',
        'title' => 'Prestasi Sekolah',
        'subtitle' => 'Pencapaian siswa dan sekolah SMK Negeri 9 Muaro Jambi',
    ])

    <section class="page-section blog-achievements">
        <div class="container">

            <div class="ach-topbar">
                <div class="ach-topbar-left">
                    <h2 class="ach-h2">Daftar Prestasi</h2>
                    <p class="ach-sub">Dokumentasi prestasi yang berhasil diraih oleh siswa maupun sekolah SMK Negeri 9 Muaro
                        Jambi.</p>
                </div>

                <div class="ach-topbar-right">
                    <a class="ach-back" href="{{ route('blog.index') }}">Kembali ke Blog</a>
                </div>
            </div>

            <div class="ach-grid">
                @forelse ($posts as $post)
                    <a class="ach-card" href="{{ route('blog.show', $post->slug) }}">

                        <div class="ach-card-top">
                            <span class="ach-level">
                                {{ $post->level ?? 'Prestasi' }}
                            </span>

                            <span class="ach-date">
                                {{ optional($post->awarded_at)->format('d M Y') ?? optional($post->published_at)->format('d M Y') }}
                            </span>
                        </div>

                        <h3 class="ach-title">{{ $post->title }}</h3>

                        @if (!empty($post->excerpt))
                            <p class="ach-excerpt">{{ $post->excerpt }}</p>
                        @endif

                        <div class="ach-foot">
                            <span class="ach-more">Lihat detail</span>
                            <span class="ach-arrow" aria-hidden="true">→</span>
                        </div>

                    </a>
                @empty
                    <div class="ach-empty">
                        <h3>Belum ada prestasi</h3>
                        <p>Prestasi sekolah akan ditampilkan di halaman ini setelah dipublikasikan.</p>
                        <a class="ach-back" href="{{ route('blog.index') }}">Kembali ke Blog</a>
                    </div>
                @endforelse
            </div>

            <div class="ach-pagination">
                {{ $posts->links() }}
            </div>

        </div>
    </section>

@endsection
