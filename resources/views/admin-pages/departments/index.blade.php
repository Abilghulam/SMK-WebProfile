@extends('layouts.app-admin')

@section('title', 'Panel Program Keahlian')
@section('kicker', 'Konten')
@section('page_title', 'Program Keahlian')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Daftar Program Keahlian</h1>
                <p class="adm-subtitle">Kelola jurusan/program keahlian yang tampil di halaman pengguna.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.departments.create') }}">
                    <span class="adm-btn-ic" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-layers-plus-icon lucide-layers-plus">
                            <path
                                d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 .83.18 2 2 0 0 0 .83-.18l8.58-3.9a1 1 0 0 0 0-1.831z" />
                            <path d="M16 17h6" />
                            <path d="M19 14v6" />
                            <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 .825.178" />
                            <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l2.116-.962" />
                        </svg></span>
                    Tambah Program
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers">
                                <path
                                    d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z" />
                                <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12" />
                                <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17" />
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
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
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
