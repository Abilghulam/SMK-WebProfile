@extends('layouts.app-admin')

@section('title', 'Panel Dokumentasi')
@section('kicker', 'Konten')
@section('page_title', 'Dokumentasi')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Daftar Album Dokumentasi</h1>
                <p class="adm-subtitle">Kelola album dokumentasi dan item galeri.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.documentation.galleries.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true">＋</span>
                    Tambah Album
                </a>
            </div>
        </div>

        <div class="adm-card adm-card--pad">
            <form class="adm-filters" method="GET" action="{{ route('admin.documentation.galleries.index') }}">
                <div class="adm-field">
                    <label class="adm-label">Kategori</label>
                    <select class="adm-select" name="category">
                        <option value="all" {{ ($category ?? 'all') === 'all' ? 'selected' : '' }}>Semua</option>

                        @foreach ($categories as $cat)
                            @php
                                // Label tampil rapi: "kegiatan_sekolah" -> "Kegiatan Sekolah", "kegiatan-sekolah" -> "Kegiatan Sekolah"
                                $label = \Illuminate\Support\Str::of($cat)
                                    ->replace(['-', '_'], ' ')
                                    ->title();
                            @endphp

                            <option value="{{ $cat }}" {{ ($category ?? '') === $cat ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="adm-field">
                    <label class="adm-label">Status</label>
                    <select class="adm-select" name="status">
                        <option value="" {{ ($status ?? '') === '' ? 'selected' : '' }}>Semua</option>
                        <option value="published" {{ ($status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ ($status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="adm-field adm-field--grow">
                    <label class="adm-label">Cari</label>
                    <input class="adm-input" type="text" name="q" value="{{ $search ?? '' }}"
                        placeholder="Cari judul/slug...">
                </div>

                <div class="adm-filter-actions">
                    <button class="adm-icon-btn adm-icon-btn--apply" type="submit" title="Terapkan filter"
                        aria-label="Terapkan filter">
                        <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="2" />
                            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.documentation.galleries.index') }}"
                        title="Reset filter" aria-label="Reset filter">
                        <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M21 12a9 9 0 1 1-2.64-6.36" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 3v6h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <section class="adm-doc-grid">
            @forelse ($galleries as $gal)
                <article class="adm-doc-card">
                    <div class="adm-doc-cover">
                        <img src="{{ $gal->cover_url }}" alt="{{ $gal->title ?? 'Album' }}">
                        <div class="adm-doc-cover-top">
                            @php
                                $catLabel = $gal->category
                                    ? \Illuminate\Support\Str::of($gal->category)
                                        ->replace(['-', '_'], ' ')
                                        ->title()
                                    : '—';
                            @endphp

                            <span class="adm-badge">{{ $catLabel }}</span>

                            <span class="adm-doc-status">
                                @if ($gal->is_published)
                                    <span class="adm-badge adm-badge--success" data-doc-status-badge>Published</span>
                                @else
                                    <span class="adm-badge adm-badge--muted" data-doc-status-badge>Draft</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="adm-doc-body">
                        <div class="adm-doc-title">{{ $gal->title ?: 'Tanpa Judul' }}</div>
                        <div class="adm-doc-sub">
                            <span class="adm-muted">{{ $gal->slug }}</span>
                            <span class="adm-dot">•</span>
                            <span class="adm-muted">
                                {{ optional($gal->event_date)->format('d M Y') ?? optional($gal->created_at)->format('d M Y') }}
                            </span>
                        </div>

                        <div class="adm-doc-meta">
                            <div class="adm-doc-meta-item">
                                <span class="adm-muted">Item</span>
                                <strong>{{ $gal->items_count ?? 0 }}</strong>
                            </div>
                            <div class="adm-doc-meta-item">
                                <span class="adm-muted">Update</span>
                                <strong
                                    data-doc-updated-at>{{ optional($gal->updated_at)->format('d M Y H:i') ?? '—' }}</strong>
                            </div>
                        </div>

                        <div class="adm-doc-actions">
                            <a class="adm-icon-btn adm-icon-btn--gear"
                                href="{{ route('admin.documentation.items.index', $gal) }}" title="Kelola item"
                                aria-label="Kelola item">
                                <svg class="adm-ic adm-ic--gear" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <!-- outer gear -->
                                    <path d="M12 8.5a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7Z" stroke="currentColor"
                                        stroke-width="1.8" />

                                    <path d="M19.4 15a7.8 7.8 0 0 0 .1-1
                                                               a7.8 7.8 0 0 0-.1-1l2-1.5
                                                               l-2-3.4-2.3.6
                                                               a7.9 7.9 0 0 0-1.7-1
                                                               l-.4-2.4h-4l-.4 2.4
                                                               a7.9 7.9 0 0 0-1.7 1
                                                               l-2.3-.6-2 3.4 2 1.5
                                                               a7.8 7.8 0 0 0-.1 1
                                                               a7.8 7.8 0 0 0 .1 1l-2 1.5
                                                               2 3.4 2.3-.6
                                                               a7.9 7.9 0 0 0 1.7 1
                                                               l.4 2.4h4l.4-2.4
                                                               a7.9 7.9 0 0 0 1.7-1
                                                               l2.3.6 2-3.4-2-1.5Z" stroke="currentColor"
                                        stroke-width="1.6" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <a class="adm-icon-btn" href="{{ route('admin.documentation.galleries.edit', $gal) }}"
                                title="Edit album" aria-label="Edit album">
                                <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z" stroke="currentColor"
                                        stroke-width="2" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <form class="adm-doc-toggle-publish-form" method="POST"
                                action="{{ route('admin.documentation.galleries.toggle-publish', $gal) }}"
                                data-published="{{ $gal->is_published ? '1' : '0' }}">
                                @csrf
                                @method('PATCH')

                                <button class="adm-icon-btn adm-icon-btn--apply adm-toggle-publish-btn" type="submit"
                                    data-toggle-btn title="{{ $gal->is_published ? 'Jadikan Draft' : 'Publish' }}"
                                    aria-label="{{ $gal->is_published ? 'Jadikan Draft' : 'Publish' }}">
                                    <svg class="adm-ic" data-toggle-ic viewBox="0 0 24 24" fill="none"
                                        aria-hidden="true"></svg>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.documentation.galleries.destroy', $gal) }}"
                                onsubmit="return confirm('Hapus album ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="adm-icon-btn adm-icon-btn--delete" type="submit" title="Hapus"
                                    aria-label="Hapus">
                                    <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M3 6h18" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" />
                                        <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="adm-empty">
                    <div class="adm-empty-title">Belum ada album.</div>
                    <div class="adm-empty-sub">Buat album dokumentasi untuk menampilkan galeri di halaman pengguna.</div>
                </div>
            @endforelse
        </section>

        <div style="margin-top:14px;">
            {{ $galleries->links() }}
        </div>
    </div>
@endsection
