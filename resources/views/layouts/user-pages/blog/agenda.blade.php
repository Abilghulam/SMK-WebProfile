@extends('layouts.app')

@section('title', 'Agenda Sekolah | SMK Negeri 9 Muaro Jambi')
@section('meta_description', 'Agenda dan kegiatan sekolah SMK Negeri 9 Muaro Jambi')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Blog',
        'title' => 'Agenda Sekolah',
        'subtitle' => 'Agenda dan kegiatan SMK Negeri 9 Muaro Jambi',
    ])

    <section class="page-section blog-agenda">
        <div class="container">

            <div class="agenda-topbar">
                <div class="agenda-topbar-left">
                    <h2 class="agenda-h2">Agenda Terdekat</h2>
                    <p class="agenda-sub">Jadwal kegiatan yang akan berlangsung di SMK Negeri 9 Muaro Jambi.</p>
                </div>

                <div class="agenda-topbar-right">
                    <a class="agenda-back" href="{{ route('blog.index') }}">Kembali ke Blog</a>
                </div>
            </div>

            {{-- UPCOMING --}}
            <div class="agenda-grid">
                <div class="agenda-card">
                    <div class="agenda-card-head">
                        <h3>Upcoming</h3>
                        <span class="agenda-badge agenda-badge--upcoming">Akan datang</span>
                    </div>

                    @forelse ($upcoming as $post)
                        @include('layouts.user-pages.blog.partials._agenda-row', [
                            'post' => $post,
                            'state' => 'upcoming',
                        ])
                    @empty
                        <div class="agenda-empty">
                            <h4>Tidak ada agenda terdekat</h4>
                            <p>Agenda yang akan datang akan muncul di sini setelah dipublikasikan.</p>
                        </div>
                    @endforelse

                    <div class="agenda-pagination">
                        {{ $upcoming->links() }}
                    </div>
                </div>

                {{-- PAST --}}
                <div class="agenda-card">
                    <div class="agenda-card-head">
                        <h3>Riwayat</h3>
                        <span class="agenda-badge agenda-badge--past">Selesai</span>
                    </div>

                    @forelse ($past as $post)
                        @include('layouts.user-pages.blog.partials._agenda-row', [
                            'post' => $post,
                            'state' => 'past',
                        ])
                    @empty
                        <div class="agenda-empty">
                            <h4>Belum ada riwayat agenda</h4>
                            <p>Agenda yang sudah berlalu akan tercatat di sini.</p>
                        </div>
                    @endforelse

                    <div class="agenda-pagination">
                        {{ $past->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
