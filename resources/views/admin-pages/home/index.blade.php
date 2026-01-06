@extends('layouts.app-admin')

@section('title', 'Panel Home Management')
@section('kicker', 'Konten')
@section('page_title', 'Home Management')

@section('content')
    <section class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Kelola Halaman Utama</h1>
                <p class="adm-subtitle">Kelola konten halaman Home (Profil Sekolah, Statistik Sekolah, dan Kepala Sekolah).
                </p>
            </div>
        </div>

        <div class="adm-grid adm-grid--stats" style="grid-template-columns:repeat(3,minmax(0,1fr));">
            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-school-icon lucide-school">
                        <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                        <path d="M18 5v16" />
                        <path d="m4 6 7.106-3.79a2 2 0 0 1 1.788 0L20 6" />
                        <path
                            d="m6 11-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11" />
                        <path d="M6 5v16" />
                        <circle cx="12" cy="9" r="2" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">School Profile</div>
                    <div class="adm-stat-value">{{ $profile?->school_name ? 'Identitas' : '—' }}</div>
                    <div class="adm-stat-meta">Identitas, visi-misi, NPSN, akreditasi</div>

                    <div style="margin-top:14px;">
                        <a class="home adm-btn adm-btn--primary" href="{{ route('admin.home.profile.edit') }}">
                            <span class="adm-btn-ic" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path
                                        d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                </svg>
                            </span>
                            Edit
                        </a>
                    </div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-no-axes-combined-icon lucide-chart-no-axes-combined">
                        <path d="M12 16v5" />
                        <path d="M16 14v7" />
                        <path d="M20 10v11" />
                        <path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15" />
                        <path d="M4 18v3" />
                        <path d="M8 14v7" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">School Statistics</div>
                    <div class="adm-stat-value">{{ $stats?->academic_year ?? '—' }}</div>
                    <div class="adm-stat-meta">Siswa, guru, jurusan, tahun ajaran</div>

                    <div style="margin-top:14px;">
                        <a class="home adm-btn adm-btn--primary" href="{{ route('admin.home.statistics.edit') }}">
                            <span class="adm-btn-ic" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path
                                        d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                </svg>
                            </span>
                            Edit
                        </a>
                    </div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="1.8" />
                        <path d="M4 21a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">Principal</div>
                    <div class="adm-stat-value">{{ $principal?->position ?? '—' }}</div>
                    <div class="adm-stat-meta">Nama, jabatan, foto, sambutan</div>

                    <div style="margin-top:14px;">
                        <a class="home adm-btn adm-btn--primary" href="{{ route('admin.home.principal.edit') }}">
                            <span class="adm-btn-ic" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path
                                        d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                </svg>
                            </span>
                            Edit
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
