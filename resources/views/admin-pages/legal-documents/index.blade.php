@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Legalitas</h1>
                <p class="adm-subtitle">Kelola dokumen legal sekolah: upload PDF atau tautan eksternal.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.legal-documents.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true">＋</span>
                    Tambah Post
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
                        <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="2" />
                            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.legal-documents.index') }}"
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
                            <svg class="adm-legal-filebadge-ic" viewBox="0 0 24 24" fill="none">
                                <path d="M8 3h6l4 4v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor"
                                    stroke-width="1.8" stroke-linejoin="round" />
                                <path d="M14 3v5h5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
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
                            <strong>{{ optional($doc->published_at)->format('d M Y H:i') ?? '—' }}</strong>
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
                                <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M14 3h7v7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M10 14 21 3" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                    <path d="M21 14v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </a>
                        @endif

                        <a class="adm-icon-btn" href="{{ route('admin.legal-documents.edit', $doc) }}" title="Edit"
                            aria-label="Edit">
                            <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z" stroke="currentColor"
                                    stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('admin.legal-documents.toggle-publish', $doc) }}"
                            class="adm-toggle-publish-form" data-published="{{ $doc->is_published ? '1' : '0' }}">
                            @csrf
                            @method('PATCH')

                            <button class="adm-icon-btn adm-toggle-publish-btn" type="submit"
                                title="{{ $doc->is_published ? 'Jadikan Draft' : 'Publish' }}"
                                aria-label="{{ $doc->is_published ? 'Jadikan Draft' : 'Publish' }}" data-toggle-btn>
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
                                <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M3 6h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
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
                </article>
            @empty
                <div class="adm-empty">
                    <div class="adm-empty-title">Belum ada dokumen.</div>
                    <div class="adm-empty-sub">Tambahkan dokumen legalitas untuk ditampilkan di halaman pengguna.</div>
                </div>
            @endforelse
        </section>

        <div class="adm-paginate">
            {{ $docs->links() }}
        </div>
    </div>
@endsection
