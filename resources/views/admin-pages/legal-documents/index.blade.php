@extends('layouts.app-admin')

@section('title', 'Panel Legalitas')
@section('kicker', 'Konten')
@section('page_title', 'Legalitas')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Daftar Dokumen Legalitas</h1>
                <p class="adm-subtitle">Kelola dokumen legal sekolah: upload PDF atau tautan eksternal.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.legal-documents.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-plus-corner-icon lucide-file-plus-corner">
                            <path
                                d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            <path d="M14 19h6" />
                            <path d="M17 16v6" />
                        </svg>
                    </span>
                    Tambah Dokumen
                </a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form class="adm-filters" method="GET" action="{{ route('admin.legal-documents.index') }}">
                <div class="adm-field">
                    <label class="adm-label">Kategori</label>
                    <select class="adm-select" name="category">
                        <option value="all" {{ ($category ?? 'all') === 'all' ? 'selected' : '' }}>
                            Semua
                        </option>

                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>
                                {{ Str::of($cat)->replace('_', ' ')->title() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="adm-field">
                    <label class="adm-label">Status</label>
                    <select class="adm-select" name="status">
                        <option value="" {{ $status === '' ? 'selected' : '' }}>Semua</option>
                        <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
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

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.legal-documents.index') }}"
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
        </section>

        <section class="adm-legal-grid">
            @forelse ($docs as $doc)
                <article class="adm-legal-card">
                    <div class="adm-legal-top">
                        @php
                            $fileType = strtolower($doc->file_type ?? '');
                            $fileType = $fileType ?: strtolower(pathinfo($doc->file_path ?? '', PATHINFO_EXTENSION));
                            $fileLabel = match (true) {
                                $fileType === 'pdf' => 'PDF',
                                in_array($fileType, ['doc', 'docx']) => 'DOC',
                                in_array($fileType, ['xls', 'xlsx']) => 'XLS',
                                default => 'FILE',
                            };

                            $fileClass = match (true) {
                                $fileType === 'pdf' => 'pdf',
                                in_array($fileType, ['doc', 'docx']) => 'doc',
                                in_array($fileType, ['xls', 'xlsx']) => 'xls',
                                default => 'file',
                            };
                        @endphp
                        <div class="adm-legal-filebadge adm-legal-filebadge--{{ $fileClass }}" aria-hidden="true">
                            <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                            </svg>

                            <span class="adm-legal-filebadge-label">
                                {{ $fileLabel }}
                            </span>
                        </div>

                        <div class="adm-legal-main">
                            <div class="adm-legal-title">{{ $doc->title }}</div>
                        </div>


                    </div>

                    @if ($doc->description)
                        <div class="adm-legal-desc">{{ $doc->description }}</div>
                    @endif

                    <div class="adm-legal-meta">
                        <div class="adm-legal-meta-item">
                            <span class="adm-muted">Kategori</span>
                            <strong>{{ $doc->categoryLabel() }}</strong>
                        </div>

                        <div class="adm-legal-meta-item">
                            <span class="adm-muted">Ukuran</span>
                            <strong>{{ $doc->file_size ? number_format($doc->file_size / 1024, 0) . ' KB' : '—' }}</strong>
                        </div>

                        <div class="adm-legal-meta-item">
                            <span class="adm-muted">Unduhan</span>
                            <strong>{{ $doc->download_count ?? 0 }}</strong>
                        </div>

                        <div class="adm-legal-meta-item">
                            <span class="adm-muted">Publikasi</span>
                            <strong data-legal-published-at>
                                {{ optional($doc->published_at)->format('d M Y H:i') ?? '—' }}
                            </strong>
                        </div>
                    </div>

                    <div class="adm-legal-actions">
                        <div class="adm-legal-status">
                            <span class="adm-badge {{ $doc->is_published ? 'adm-badge--success' : 'adm-badge--muted' }}"
                                data-legal-status-badge data-status="{{ $doc->is_published ? 'published' : 'draft' }}">
                                {{ $doc->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        @if ($doc->download_url)
                            <a class="adm-icon-btn" href="{{ $doc->download_url }}" target="_blank" rel="noopener"
                                title="Buka dokumen" aria-label="Buka dokumen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-external-link-icon lucide-external-link">
                                    <path d="M15 3h6v6" />
                                    <path d="M10 14 21 3" />
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                </svg>
                            </a>
                        @endif

                        <a class="adm-icon-btn" href="{{ route('admin.legal-documents.edit', $doc) }}" title="Edit"
                            aria-label="Edit">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('admin.legal-documents.toggle-publish', $doc) }}"
                            class="adm-toggle-publish-form" data-published="{{ $doc->is_published ? '1' : '0' }}">
                            @csrf
                            @method('PATCH')

                            <button class="adm-icon-btn adm-icon-btn--apply adm-toggle-publish-btn" type="submit"
                                title="{{ $doc->is_published ? 'Draft' : 'Publish' }}"
                                aria-label="{{ $doc->is_published ? 'Draft' : 'Publish' }}" data-toggle-btn>
                                {{-- SINGLE ICON (path diisi via JS sesuai status) --}}
                                <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true"
                                    data-toggle-ic></svg>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.legal-documents.destroy', $doc) }}"
                            onsubmit="return confirm('Hapus dokumen ini?')">
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
                </article>
            @empty
                <div class="adm-empty">
                    <div class="adm-empty-title">Belum ada dokumen.</div>
                    <div class="adm-empty-sub">Tambahkan dokumen legalitas untuk ditampilkan di halaman pengguna.</div>
                </div>
            @endforelse
        </section>

        <div class="adm-pagination">
            {{ $docs->links() }}
        </div>
    </div>
@endsection
