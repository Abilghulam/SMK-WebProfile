@extends('layouts.app-admin')

@section('title', 'Panel Blog')
@section('kicker', 'Konten')
@section('page_title', 'Blog (Post)')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Daftar Posts</h1>
                <p class="adm-subtitle">Kelola berita, agenda, prestasi, dan konten lainnya.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.posts.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true">＋</span>
                    Tambah Post
                </a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="adm-card adm-card--pad">
            <form class="adm-filters" method="GET" action="{{ route('admin.posts.index') }}">
                <div class="adm-field">
                    <label class="adm-label">Type</label>
                    <select class="adm-select" name="type">
                        <option value="all" {{ ($type ?? 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                        @foreach ($typeOptions as $k => $v)
                            <option value="{{ $k }}" {{ ($type ?? '') === $k ? 'selected' : '' }}>
                                {{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="adm-field">
                    <label class="adm-label">Status</label>
                    <select class="adm-select" name="status">
                        <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="published" {{ ($status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ ($status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="adm-field adm-field--grow">
                    <label class="adm-label">Cari</label>
                    <input class="adm-input" type="text" name="q" value="{{ $q ?? '' }}"
                        placeholder="Cari title/slug...">
                </div>

                <div class="adm-filter-actions">
                    <button class="adm-icon-btn adm-icon-btn--apply" type="submit" title="Terapkan filter"
                        aria-label="Terapkan filter">
                        <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M11 19a8 8 0 1 1 0-16a8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.posts.index') }}"
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

        {{-- Table --}}
        <div class="adm-card adm-card--pad adm-card--table">
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th style="width:140px;">Type</th>
                            <th style="width:170px;">Status</th>
                            <th style="width:170px;">Tanggal</th>
                            <th style="width:150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>
                                    <div class="adm-title">
                                        <div class="adm-title-main">{{ $post->title }}</div>
                                        <div class="adm-title-sub">/{{ $post->slug }}</div>
                                    </div>
                                </td>

                                <td>
                                    <span class="adm-badge adm-badge--neutral">{{ $post->type_label }}</span>
                                </td>

                                <td>
                                    @if ($post->is_published)
                                        <span class="adm-badge adm-badge--success">Published</span>
                                    @else
                                        <span class="adm-badge adm-badge--muted">Draft</span>
                                    @endif

                                    @if ($post->is_featured)
                                        <span class="adm-badge adm-badge--warn">Featured</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="adm-date">
                                        <span class="adm-date-chip" title="Tanggal">
                                            <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M8 3v3M16 3v3" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M4 9h16" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M6 5h12a2 2 0 012 2v13a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                            </svg>
                                            {{ optional($post->published_at ?? $post->created_at)->translatedFormat('d M Y') }}
                                        </span>

                                        <span class="adm-date-chip adm-date-chip--time" title="Jam">
                                            <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M12 7v6l4 2" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                                    stroke-width="2" />
                                            </svg>
                                            {{ optional($post->published_at ?? $post->created_at)->format('H:i') }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <div class="adm-row-actions">
                                        <a class="adm-icon-btn adm-icon-btn--edit"
                                            href="{{ route('admin.posts.edit', $post) }}" title="Edit"
                                            aria-label="Edit">
                                            {{-- icon pencil --}}
                                            <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M12 20h9" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4 11.5-11.5z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                            onsubmit="return confirm('Hapus post ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="adm-icon-btn adm-icon-btn--delete" type="submit"
                                                title="Hapus" aria-label="Hapus">
                                                {{-- icon trash --}}
                                                <svg class="adm-ic" viewBox="0 0 24 24" fill="none"
                                                    aria-hidden="true">
                                                    <path d="M3 6h18" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M8 6V4h8v2" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M6 6l1 16h10l1-16" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="adm-empty">Belum ada post.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="adm-pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
