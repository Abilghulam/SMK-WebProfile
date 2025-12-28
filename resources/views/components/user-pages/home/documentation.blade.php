<section class="home-docs">
    <div class="container">

        <div class="home-docs-head">
            <div class="home-docs-title">
                <h2>Dokumentasi Terbaru</h2>
                <p>Cuplikan kegiatan, prestasi, dan aktivitas sekolah yang terbaru.</p>
            </div>

            <a class="home-docs-cta" href="{{ route('documentation.index') }}">
                Lihat Semua
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="home-docs-grid">
            @forelse ($latestGalleries as $gallery)
                <a class="home-docs-card" href="{{ route('documentation.show', $gallery->slug) }}">

                    <div class="home-docs-cover">
                        <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" loading="lazy">

                        @if (!empty($gallery->category))
                            <span class="home-docs-badge">
                                {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $gallery->category)) }}
                            </span>
                        @endif
                    </div>

                    <div class="home-docs-body">
                        <h3 class="home-docs-name">{{ $gallery->title }}</h3>

                        <div class="home-docs-meta">
                            <span>
                                {{ optional($gallery->event_date)->format('d M Y') ?? optional($gallery->created_at)->format('d M Y') }}
                            </span>

                            <span class="sep">|</span>

                            <span>
                                {{ $gallery->photos_count ?? 0 }} Foto
                            </span>

                            @if (!empty($gallery->videos_count))
                                <span class="sep">|</span>
                                <span>
                                    {{ $gallery->videos_count }} Video
                                </span>
                            @endif
                        </div>

                    </div>

                </a>
            @empty
                <div class="home-docs-empty">
                    <h3>Belum ada dokumentasi</h3>
                    <p>Nantinya dokumentasi terbaru akan tampil di sini.</p>
                    <a class="home-docs-cta" href="{{ route('documentation.index') }}">Buka Dokumentasi</a>
                </div>
            @endforelse
        </div>

    </div>
</section>
