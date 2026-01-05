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
                    <span class="adm-btn-ic" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-image-plus-icon lucide-image-plus">
                            <path d="M16 5h6" />
                            <path d="M19 2v6" />
                            <path d="M21 11.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5" />
                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                            <circle cx="9" cy="9" r="2" />
                        </svg></span>
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
                        <svg class="adm-ic" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-text-search-icon lucide-text-search">
                            <path d="M21 5H3" />
                            <path d="M10 12H3" />
                            <path d="M10 19H3" />
                            <circle cx="17" cy="15" r="3" />
                            <path d="m21 19-1.9-1.9" />
                        </svg>
                    </button>

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.documentation.galleries.index') }}"
                        title="Reset filter" aria-label="Reset filter">
                        <svg class="adm-ic" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-rotate-ccw-icon lucide-rotate-ccw">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                            <path d="M3 3v5h5" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-images-icon lucide-images">
                                    <path d="m22 11-1.296-1.296a2.4 2.4 0 0 0-3.408 0L11 16" />
                                    <path d="M4 8a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2" />
                                    <circle cx="13" cy="7" r="1" fill="currentColor" />
                                    <rect x="8" y="2" width="14" height="14" rx="2" />
                                </svg>
                            </a>

                            <a class="adm-icon-btn" href="{{ route('admin.documentation.galleries.edit', $gal) }}"
                                title="Edit album" aria-label="Edit album">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash2-icon lucide-trash-2">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
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

        <div class="adm-pagination">
            {{ $galleries->links() }}
        </div>
    </div>
@endsection
