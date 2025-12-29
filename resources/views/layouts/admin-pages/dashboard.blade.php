@extends('layouts.app-admin')

@section('title', 'Dashboard Admin')

@section('kicker', 'Admin')
@section('page_title', 'Dashboard')

@section('content')
    <section class="adm-wrap">

        {{-- Page intro --}}
        <div class="adm-hero">
            <div class="adm-hero-left">
                <div class="adm-hero-kicker">Panel Administrasi</div>
                <h2 class="adm-hero-title">
                    Selamat datang, {{ auth()->user()->name ?? 'Admin' }}.
                </h2>
                <p class="adm-hero-sub">
                    Kelola konten website sekolah secara terstruktur dan aman. Gunakan menu di samping untuk mengakses
                    modul.
                </p>
            </div>

            <div class="adm-hero-right">
                <div class="adm-hero-card">
                    <div class="adm-hero-card-ic" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M4 10.5 12 4l8 6.5V20a1.5 1.5 0 0 1-1.5 1.5H5.5A1.5 1.5 0 0 1 4 20v-9.5Z"
                                stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                            <path d="M9 21v-7h6v7" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="adm-hero-card-body">
                        <div class="adm-hero-card-title">Status Sistem</div>
                        <div class="adm-hero-card-sub">Dashboard aktif & siap digunakan</div>
                    </div>
                </div>

                <div class="adm-hero-note">
                    <div class="adm-hero-note-label">Catatan</div>
                    <div class="adm-hero-note-text">
                        Prioritaskan update informasi penting (PPDB, agenda sekolah, dan dokumen legalitas).
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick stats (placeholder, nanti bisa dihubungkan ke DB) --}}
        <div class="adm-grid adm-grid--stats">
            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M8 3h7l3 3v15a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor"
                            stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M9 10h6M9 14h6M9 18h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Konten Blog</div>
                    <div class="adm-stat-value">—</div>
                    <div class="adm-stat-meta">Berita, agenda, prestasi</div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M7 3h7l3 3v15a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z" stroke="currentColor"
                            stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M10 12h7M10 16h7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Dokumen Legalitas</div>
                    <div class="adm-stat-value">—</div>
                    <div class="adm-stat-meta">Unduhan & publikasi</div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"
                            stroke="currentColor" stroke-width="1.8" />
                        <path d="M8.5 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor" stroke-width="1.8" />
                        <path d="m21 16-5-5-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Dokumentasi</div>
                    <div class="adm-stat-value">—</div>
                    <div class="adm-stat-meta">Album & item galeri</div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 3 3 8l9 5 9-5-9-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M3 12l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M3 16l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Akademik</div>
                    <div class="adm-stat-value">—</div>
                    <div class="adm-stat-meta">Program & fasilitas</div>
                </div>
            </article>
        </div>

        {{-- Quick actions --}}
        <div class="adm-grid adm-grid--two">
            <section class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title">Aksi Cepat</h3>
                    <p class="adm-card-sub">Shortcut untuk pekerjaan yang paling sering dilakukan.</p>
                </div>

                <div class="adm-actions">
                    <a class="adm-action" href="{{ url('/admin/posts') }}">
                        <span class="adm-action-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M8 3h7l3 3v15a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                    stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                <path d="M9 10h6M9 14h6" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                        </span>
                        Kelola Blog
                        <span class="adm-action-go" aria-hidden="true">→</span>
                    </a>

                    <a class="adm-action" href="{{ url('/admin/legal-documents') }}">
                        <span class="adm-action-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M7 3h7l3 3v15a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z"
                                    stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                <path d="M10 12h7M10 16h7" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                        </span>
                        Kelola Legalitas
                        <span class="adm-action-go" aria-hidden="true">→</span>
                    </a>

                    <a class="adm-action" href="{{ url('/admin/galleries') }}">
                        <span class="adm-action-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"
                                    stroke="currentColor" stroke-width="1.8" />
                                <path d="m21 16-5-5-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                        Kelola Dokumentasi
                        <span class="adm-action-go" aria-hidden="true">→</span>
                    </a>
                </div>
            </section>

            <section class="adm-card adm-card--muted">
                <div class="adm-card-head">
                    <h3 class="adm-card-title">Panduan Ringkas</h3>
                    <p class="adm-card-sub">Agar tampilan user-pages tetap rapi dan konsisten.</p>
                </div>

                <ul class="adm-list">
                    <li>Gunakan judul singkat & deskriptif pada konten Blog.</li>
                    <li>Pastikan thumbnail jelas dan proporsional.</li>
                    <li>Untuk agenda, isi tanggal & lokasi secara konsisten.</li>
                    <li>Untuk legalitas, gunakan file PDF dan kategori yang tepat.</li>
                </ul>

                <div class="adm-note">
                    <span class="adm-note-ic" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 22s8-4 8-10V6l-8-3-8 3v6c0 6 8 10 8 10Z" stroke="currentColor" stroke-width="1.8"
                                stroke-linejoin="round" />
                            <path d="M9.5 12l1.8 1.8L15.8 9.3" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span>Tip: Hindari kapital berlebihan pada judul; lebih terlihat institusional.</span>
                </div>
            </section>
        </div>
    </section>
@endsection
