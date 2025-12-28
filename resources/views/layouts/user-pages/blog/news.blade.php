@extends('layouts.app')

@section('title', 'Berita Sekolah | SMK Negeri 9 Muaro Jambi')
@section('meta_description', 'Berita terbaru dan informasi resmi dari SMK Negeri 9 Muaro Jambi')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Blog',
        'title' => 'Berita Sekolah',
        'subtitle' => 'Informasi dan berita terbaru dari SMK Negeri 9 Muaro Jambi',
    ])

    <section class="page-section blog-news">
        <div class="container">

            <div class="blog-topbar">
                <div class="blog-topbar-left">
                    <h2 class="blog-h2">Daftar Berita</h2>
                    <p class="blog-sub">Update terbaru, pengumuman, dan informasi resmi SMK Negeri 9 Muaro Jambi.</p>
                </div>

                <div class="blog-topbar-right">
                    <a class="blog-back" href="{{ route('blog.index') }}">Kembali ke Blog</a>
                </div>
            </div>

            <div class="blog-grid">
                @forelse ($posts as $post)
                    @include('layouts.user-pages.blog.partials._card', ['post' => $post])
                @empty
                    <div class="blog-empty-box">
                        <h3>Belum ada berita</h3>
                        <p>Konten berita akan muncul di sini setelah dipublikasikan.</p>
                        <a class="blog-back" href="{{ route('blog.index') }}">Kembali ke Blog</a>
                    </div>
                @endforelse
            </div>

            <div class="blog-pagination">
                {{ $posts->links() }}
            </div>

        </div>
    </section>

@endsection
