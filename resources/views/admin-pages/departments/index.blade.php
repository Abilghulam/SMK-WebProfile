@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Program Keahlian</h1>
                <p class="adm-subtitle">Kelola jurusan/program keahlian yang tampil di halaman pengguna.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.departments.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true">＋</span>
                    Tambah Program Keahlian
                </a>
            </div>
        </div>

        <section class="adm-dep-grid">
            @forelse ($departments as $dep)
                <article class="adm-dep-card">
                    {{-- Cover preview --}}
                    <div class="adm-dep-cover">
                        @if (!empty($dep->cover_url))
                            <img src="{{ $dep->cover_url }}" alt="{{ $dep->name }}" loading="lazy">
                        @else
                            <div class="adm-dep-cover-fallback" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"
                                        stroke="currentColor" stroke-width="1.8" />
                                    <path d="M8.5 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor"
                                        stroke-width="1.8" />
                                    <path d="m21 16-5-5-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        @endif

                        {{-- Overlay top (mirip documentation) --}}
                        <div class="adm-dep-cover-top">
                            @if (!empty($dep->abbr))
                                <span class="adm-badge adm-dep-abbr" title="Singkatan program"
                                    aria-label="Singkatan program">
                                    {{ $dep->abbr }}
                                </span>
                            @endif

                            <span class="adm-dep-status" data-dep-status-wrap>
                                @if ($dep->is_active)
                                    <span class="adm-badge adm-badge--success" data-dep-status-badge>Aktif</span>
                                @else
                                    <span class="adm-badge adm-badge--muted" data-dep-status-badge>Nonaktif</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="adm-dep-top">
                        <div class="adm-dep-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3 3 8l9 5 9-5-9-5Z" stroke="currentColor" stroke-width="1.8"
                                    stroke-linejoin="round" />
                                <path d="M3 12l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                <path d="M3 16l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                            </svg>
                        </div>

                        <div class="adm-dep-main">
                            <div class="adm-dep-title">{{ $dep->name }}</div>
                            <div class="adm-dep-sub">
                                <span class="adm-muted">{{ $dep->slug }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($dep->short_description)
                        <div class="adm-dep-desc">{{ $dep->short_description }}</div>
                    @endif

                    <div class="adm-dep-meta adm-dep-meta--compact">
                        <div class="adm-dep-meta-item">
                            <span class="adm-muted">Durasi</span>
                            <strong>{{ $dep->duration_years }} th</strong>
                        </div>

                        <div class="adm-dep-meta-item">
                            <span class="adm-muted">Update</span>
                            <strong
                                data-dep-updated-at>{{ optional($dep->updated_at)->format('d M Y H:i') ?? '—' }}</strong>
                        </div>
                    </div>

                    <div class="adm-dep-actions">
                        <a class="adm-icon-btn adm-icon-btn--edit" href="{{ route('admin.departments.edit', $dep) }}"
                            title="Edit" aria-label="Edit">
                            <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z" stroke="currentColor"
                                    stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <form class="adm-dep-toggle-active-form" method="POST"
                            action="{{ route('admin.departments.toggle-active', $dep) }}"
                            data-active="{{ $dep->is_active ? '1' : '0' }}">
                            @csrf
                            @method('PATCH')

                            <button class="adm-icon-btn adm-icon-btn--apply adm-toggle-active-btn adm-icon-btn--apply"
                                type="submit" data-toggle-btn title="{{ $dep->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                aria-label="{{ $dep->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <svg class="adm-ic" data-toggle-ic viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true"></svg>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.departments.destroy', $dep) }}"
                            onsubmit="return confirm('Hapus program keahlian ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="adm-icon-btn adm-icon-btn--delete" type="submit" title="Hapus"
                                aria-label="Hapus">
                                <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M3 6h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
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
                    <div class="adm-empty-title">Belum ada program keahlian.</div>
                    <div class="adm-empty-sub">Klik “Tambah Program” untuk membuat data baru.</div>
                </div>
            @endforelse
        </section>

        <div class="adm-pagination">
            {{ $departments->links() }}
        </div>
    </div>
@endsection
