@extends('layouts.app-admin')

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
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 20h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <path d="M6 20V8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12" stroke="currentColor" stroke-width="1.8" />
                        <path d="M9 10h6M9 13h6M9 16h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">School Profile</div>
                    <div class="adm-stat-value">{{ $profile?->school_name ? 'Identitas' : '—' }}</div>
                    <div class="adm-stat-meta">Identitas, visi-misi, NPSN, akreditasi</div>

                    <div style="margin-top:10px;">
                        <a class="adm-btn adm-btn--primary" href="{{ route('admin.home.profile.edit') }}">Edit</a>
                    </div>
                </div>
            </article>

            <article class="adm-stat">
                <div class="adm-stat-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 19V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <path d="M20 19V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <path d="M8 17v-6M12 17V7M16 17v-9" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <div class="adm-stat-body">
                    <div class="adm-stat-label">School Statistics</div>
                    <div class="adm-stat-value">{{ $stats?->academic_year ?? '—' }}</div>
                    <div class="adm-stat-meta">Siswa, guru, jurusan, tahun ajaran</div>

                    <div style="margin-top:10px;">
                        <a class="adm-btn adm-btn--primary" href="{{ route('admin.home.statistics.edit') }}">Edit</a>
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

                    <div style="margin-top:10px;">
                        <a class="adm-btn adm-btn--primary" href="{{ route('admin.home.principal.edit') }}">Edit</a>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
