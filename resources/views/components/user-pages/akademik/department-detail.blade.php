@extends('layouts.app')

{{-- ===== PAGE META ===== --}}
@section('title', ($department->name ?? 'Program Keahlian') . ' | SMK Negeri')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($department->short_description ??
    ($department->description ?? '')), 155))

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Program Keahlian',
        'title' => $department->name ?? 'Program Keahlian',
        'subtitle' => $department->short_description ?? 'Informasi lengkap program keahlian.',
        'bgImage' => $department->image ? asset($department->image) : asset('assets/images/hero-bg.jpg'),
    ])

    <section class="page-section department-detail">
        <div class="container">

            {{-- Breadcrumb --}}
            <nav class="breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="crumb-sep">/</span>
                <a href="{{ route('departments.index') }}">Program Keahlian</a>
                <span class="crumb-sep">/</span>
                <span class="crumb-current">{{ $department->name }}</span>
            </nav>

            <div class="detail-grid">

                {{-- Main Content --}}
                <article class="detail-main">

                    @if ($department->cover_url)
                        <div class="detail-cover">
                            <img src="{{ asset($department->cover_url) }}" alt="{{ $department->name }}" loading="lazy">
                        </div>
                    @endif

                    <div class="detail-card">
                        <h2 class="detail-title">Profil Program Keahlian</h2>

                        @if (!empty($department->description))
                            <div class="detail-body">
                                {!! nl2br(e($department->description)) !!}
                            </div>
                        @else
                            <p class="detail-muted">Deskripsi program keahlian belum tersedia.</p>
                        @endif
                    </div>

                    <div class="detail-card detail-card--split">
                        <div class="detail-split">

                            {{-- Kompetensi --}}
                            <section class="info-box">
                                <h3 class="info-title">Kompetensi Keahlian</h3>

                                @if (!empty($department->competencies) && is_array($department->competencies))
                                    <ul class="info-list">
                                        @foreach ($department->competencies as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="detail-muted">Informasi kompetensi belum tersedia.</p>
                                @endif
                            </section>

                            {{-- Peluang Karir --}}
                            <section class="info-box">
                                <h3 class="info-title">Peluang Karir</h3>

                                @if (!empty($department->career_opportunities) && is_array($department->career_opportunities))
                                    <ul class="info-list">
                                        @foreach ($department->career_opportunities as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="detail-muted">Informasi peluang karir belum tersedia.</p>
                                @endif
                            </section>
                        </div>
                    </div>

                    <div class="detail-actions">
                        <a class="legal-action legal-action--back" href="{{ route('departments.index') }}">
                            <svg class="legal-action-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>

                </article>

                {{-- Side Panel --}}
                <aside class="detail-side">

                    {{-- Card: Informasi --}}
                    <div class="side-card">
                        <div class="side-head">
                            <h3>Informasi</h3>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Nama</div>
                            <div class="side-value">{{ $department->name }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Slug</div>
                            <div class="side-value mono">{{ $department->slug }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Status</div>
                            <div class="side-value">
                                <span class="status-pill status-pill--active">Aktif</span>
                            </div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Diperbarui</div>
                            <div class="side-value">
                                {{ optional($department->updated_at)->format('d M Y') ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- Card: Ringkasan Akademik --}}
                    @if (!empty($department->short_description) || !empty($department->graduate_profile))
                        <div class="side-card side-card--summary">
                            <h3>Ringkasan Akademik</h3>
                            <div class="side-row">
                                <p class="side-lead">
                                    @if (!empty($department->short_description))
                                        {{ $department->short_description }}
                                    @endif

                                    @if (!empty($department->graduate_profile))
                                        {{ !empty($department->short_description) ? ' ' : '' }}
                                        {{ $department->graduate_profile }}
                                    @endif
                                </p>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Durasi</div>
                                <div class="side-value">
                                    {{ $department->duration_years ?? 3 }} Tahun
                                </div>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Model Pembelajaran</div>
                                <div class="side-value">
                                    {{ $department->learning_model ?? 'Teori & Praktik' }}
                                </div>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Praktik Kerja Lapangan</div>
                                <div class="side-value">
                                    {{ $department->has_internship ?? true ? 'Tersedia' : 'Tidak tersedia' }}
                                </div>
                            </div>

                            <div class="side-row">
                                <div class="side-label">Kegiatan</div>
                                <div class="side-value">
                                    @if (!empty($department->learning_activities) && is_array($department->learning_activities))
                                        <ul class="side-mini-list">
                                            @foreach ($department->learning_activities as $act)
                                                <li>{{ $act }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="side-fallback">Proyek & Portofolio</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Card: Aksi Cepat --}}
                    <div class="side-card side-card--actions">
                        <h3>Aksi Cepat</h3>

                        <a class="side-action" href="{{ route('departments.index') }}">
                            Lihat Daftar Program Lainnya
                            <span style="margin-top: 7px;" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        </a>

                        <a class="side-action" href="{{ route('facilities.index') }}">
                            Lihat Fasilitas Sekolah
                            <span style="margin-top: 7px;" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        </a>
                    </div>

                </aside>
            </div>
        </div>
    </section>
@endsection
