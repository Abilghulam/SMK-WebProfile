@extends('layouts.app-admin')

@section('title', 'Panel Fasilitas')
@section('kicker', 'Konten')
@section('page_title', 'Fasilitas')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Daftar Fasilitas</h1>
                <p class="adm-subtitle">Kelola daftar fasilitas yang tampil di halaman pengguna.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.facilities.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true">＋</span>
                    Tambah Fasilitas
                </a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="adm-card adm-card--pad">
            <form class="adm-filters" method="GET" action="{{ route('admin.facilities.index') }}">
                <div class="adm-field">
                    <label class="adm-label">Kategori</label>
                    <select class="adm-select" name="category">
                        <option value="all" {{ ($category ?? 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                        @foreach ($categories as $key => $label)
                            <option value="{{ $key }}" {{ ($category ?? 'all') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="adm-field">
                    <label class="adm-label">Status</label>
                    <select class="adm-select" name="status">
                        <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="active" {{ ($status ?? 'all') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ ($status ?? 'all') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="adm-field adm-field--grow">
                    <label class="adm-label">Cari</label>
                    <input class="adm-input" type="text" name="q" value="{{ $search ?? '' }}"
                        placeholder="Cari nama fasilitas...">
                </div>

                <div class="adm-filter-actions">
                    <button class="adm-icon-btn adm-icon-btn--apply" type="submit" title="Terapkan filter"
                        aria-label="Terapkan filter">
                        <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="2" />
                            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>

                    <a class="adm-icon-btn adm-icon-btn--reset" href="{{ route('admin.facilities.index') }}"
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

        <section class="adm-fac-grid">
            @forelse ($facilities as $fac)
                @php
                    $catLabel = $fac->category_label ?: '—';
                    $imgUrl = $fac->image ? asset('storage/' . $fac->image) : null;
                @endphp

                <article class="adm-fac-card">
                    {{-- Cover preview --}}
                    <div class="adm-fac-cover">
                        @if ($imgUrl)
                            <img src="{{ $imgUrl }}" alt="{{ $fac->name }}" loading="lazy">
                        @else
                            <div class="adm-fac-cover-fallback" aria-hidden="true">
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

                        <div class="adm-fac-cover-top">
                            <span class="adm-badge">{{ $catLabel }}</span>

                            <span class="adm-fac-status" data-fac-status-wrap>
                                @if ($fac->is_active)
                                    <span class="adm-badge adm-badge--success" data-fac-status-badge>Aktif</span>
                                @else
                                    <span class="adm-badge adm-badge--muted" data-fac-status-badge>Nonaktif</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="adm-fac-top">
                        <div class="adm-fac-main">
                            <div class="adm-fac-title">{{ $fac->name }}</div>
                        </div>
                    </div>

                    @if (!empty($fac->description))
                        <div class="adm-fac-desc">{{ $fac->description }}</div>
                    @endif

                    <div class="adm-fac-meta adm-fac-meta--compact">
                        <div class="adm-fac-meta-item">
                            <span class="adm-muted">Urutan</span>
                            <strong>{{ (int) ($fac->sort_order ?? 0) }}</strong>
                        </div>

                        <div class="adm-fac-meta-item">
                            <span class="adm-muted">Update</span>
                            <strong
                                data-fac-updated-at>{{ optional($fac->updated_at)->format('d M Y H:i') ?? '—' }}</strong>
                        </div>
                    </div>

                    <div class="adm-fac-actions">
                        <a class="adm-icon-btn adm-icon-btn--edit" href="{{ route('admin.facilities.edit', $fac) }}"
                            title="Edit" aria-label="Edit">
                            <svg class="adm-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z" stroke="currentColor"
                                    stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <form class="adm-fac-toggle-active-form" method="POST"
                            action="{{ route('admin.facilities.toggle-active', $fac) }}"
                            data-active="{{ $fac->is_active ? '1' : '0' }}">
                            @csrf
                            @method('PATCH')

                            <button class="adm-icon-btn adm-icon-btn--apply adm-toggle-active-btn" type="submit"
                                data-toggle-btn title="{{ $fac->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                aria-label="{{ $fac->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <svg class="adm-ic" data-toggle-ic viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true"></svg>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.facilities.destroy', $fac) }}"
                            onsubmit="return confirm('Hapus fasilitas ini?')">
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
                    <div class="adm-empty-title">Belum ada fasilitas.</div>
                    <div class="adm-empty-sub">Klik “Tambah Fasilitas” untuk membuat data baru.</div>
                </div>
            @endforelse
        </section>

        <div class="adm-pagination">
            {{ $facilities->links() }}
        </div>
    </div>
@endsection
