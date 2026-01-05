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
                    <span class="adm-btn-ic" aria-hidden="true"> <svg xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-file-plus-corner-icon lucide-file-plus-corner">
                            <path
                                d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            <path d="M14 19h6" />
                            <path d="M17 16v6" />
                        </svg></span>
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

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.posts.index') }}"
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
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                            onsubmit="return confirm('Hapus post ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="adm-icon-btn adm-icon-btn--delete" type="submit"
                                                title="Hapus" aria-label="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
