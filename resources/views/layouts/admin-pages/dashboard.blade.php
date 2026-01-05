@extends('layouts.app-admin')

@section('title', 'Dashboard')

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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check">
                            <path
                                d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                            <path d="m9 12 2 2 4-4" />
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-newspaper-icon lucide-newspaper">
                        <path d="M15 18h-5" />
                        <path d="M18 14h-8" />
                        <path
                            d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                        <rect width="8" height="4" x="10" y="6" rx="1" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Konten Blog</div>
                    <div class="adm-stat-value">{{ number_format($stats['blog']['value'] ?? 0) }}</div>
                    <div class="adm-stat-meta">{{ $stats['blog']['meta'] ?? 'Berita, agenda, prestasi' }}</div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-file-up-icon lucide-file-up">
                        <path
                            d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M12 12v6" />
                        <path d="m15 15-3-3-3 3" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Dokumen Legalitas</div>
                    <div class="adm-stat-value">{{ number_format($stats['legal']['value'] ?? 0) }}</div>
                    <div class="adm-stat-meta">{{ $stats['legal']['meta'] ?? 'Unduhan & publikasi' }}</div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m3 16 5-7 6 6.5m6.5 2.5L16 13l-4.286 6M14 10h.01M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Dokumentasi</div>
                    <div class="adm-stat-value">{{ number_format($stats['docs']['value'] ?? 0) }}</div>
                    <div class="adm-stat-meta">{{ $stats['docs']['meta'] ?? 'Album & item galeri' }}</div>
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
                    <div class="adm-stat-value">{{ number_format($stats['acad']['value'] ?? 0) }}</div>
                    <div class="adm-stat-meta">{{ $stats['acad']['meta'] ?? 'Program & fasilitas' }}</div>
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

                <div class="adm-actions--fast">
                    <a class="adm-action" href="{{ url('/admin/posts') }}">
                        <span class="adm-action-ic" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper">
                                <path d="M15 18h-5" />
                                <path d="M18 14h-8" />
                                <path
                                    d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                                <rect width="8" height="4" x="10" y="6" rx="1" />
                            </svg>
                        </span>
                        Kelola Blog
                        <span class="adm-action-go" aria-hidden="true">→</span>
                    </a>

                    <a class="adm-action" href="{{ url('/admin/legal-documents') }}">
                        <span class="adm-action-ic" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-up-icon lucide-file-up">
                                <path
                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M12 12v6" />
                                <path d="m15 15-3-3-3 3" />
                            </svg>
                        </span>
                        Kelola Legalitas
                        <span class="adm-action-go" aria-hidden="true">→</span>
                    </a>

                    <a class="adm-action" href="{{ url('/admin/galleries') }}">
                        <span class="adm-action-ic" aria-hidden="true">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m3 16 5-7 6 6.5m6.5 2.5L16 13l-4.286 6M14 10h.01M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
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
