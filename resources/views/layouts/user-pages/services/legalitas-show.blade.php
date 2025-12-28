@extends('layouts.app')

@section('title', ($doc->title ?? 'Dokumen') . ' | ' . data_get($settings ?? null, 'site_name', 'SMK Negeri'))
@section('meta_description', $doc->description ?? 'Detail dokumen legalitas dan unduhan sekolah.')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Legalitas',
        'title' => $doc->title,
        'subtitle' => $doc->description ?: 'Dokumen resmi sekolah yang dapat diunduh.',
    ])

    <section class="page-section services-landing legal-page">
        <div class="container">

            {{-- Breadcrumb --}}
            <div class="breadcrumb-legal-detail">
                <a href="{{ url('/') }}">Home</a>
                <span class="crumb-sep">/</span>
                <a href="{{ route('services.index') }}">Layanan</a>
                <span class="crumb-sep">/</span>
                <a href="{{ route('legal.index') }}">Legalitas & Dokumen</a>
                <span class="crumb-sep">/</span>
                <span class="crumb-current">{{ \Illuminate\Support\Str::limit($doc->title, 40) }}</span>
            </div>

            <div class="legal-detail-layout">

                {{-- Main --}}
                <div class="legal-detail-main">
                    <div class="legal-detail-card">

                        <div class="legal-detail-head">
                            <div class="legal-detail-kicker">
                                <span class="legal-badge">{{ strtoupper($doc->file_type ?: 'DOKUMEN') }}</span>
                                <span class="dot"></span>
                                <span class="legal-category">
                                    {{ \Illuminate\Support\Str::headline($doc->category ?? 'legalitas') }}
                                </span>
                            </div>

                            <h1 class="legal-detail-title">{{ $doc->title }}</h1>

                            @if (!empty($doc->description))
                                <p class="legal-detail-desc">{{ $doc->description }}</p>
                            @endif
                        </div>

                        {{-- Action bar (corporate toolbar) --}}
                        <div class="legal-detail-actions">

                            <a class="legal-action legal-action--back" href="{{ route('legal.index') }}">
                                <svg class="legal-action-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span>Kembali</span>
                            </a>

                            <div class="legal-detail-actions-right">
                                @if ($doc->download_url)
                                    <a class="legal-action legal-action--download"
                                        href="{{ route('legal.download', $doc->slug) }}" target="_blank" rel="noopener">
                                        <svg class="legal-action-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M12 3v10" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                            <path d="M8 11l4 4 4-4" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4 21h16" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                        <span>Unduh Dokumen</span>
                                    </a>
                                @else
                                    <span class="legal-muted">File belum tersedia</span>
                                @endif
                            </div>

                        </div>

                        {{-- Preview PDF (tetap seperti punyamu) --}}
                        @php
                            $type = strtolower($doc->file_type ?? '');
                            $isPdf = $type === 'pdf';
                            $isInternal = !empty($doc->file_path) && empty($doc->external_url);
                        @endphp

                        @if ($isPdf && $isInternal)
                            <div class="legal-preview">
                                <iframe src="{{ asset('storage/' . $doc->file_path) }}" title="Preview dokumen"
                                    loading="lazy"></iframe>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Side --}}
                <aside class="legal-detail-side">

                    <div class="side-card">
                        <div class="side-head">
                            <h3>Informasi</h3>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Kategori</div>
                            <div class="side-value">{{ \Illuminate\Support\Str::headline($doc->category ?? '-') }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Slug</div>
                            <div class="side-value mono">{{ $doc->slug }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Tipe</div>
                            <div class="side-value">{{ strtoupper($doc->file_type ?? '-') }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Ukuran</div>
                            <div class="side-value">
                                @if (!empty($doc->file_size))
                                    {{ number_format($doc->file_size / 1024, 0) }} KB
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Diterbitkan</div>
                            <div class="side-value">{{ optional($doc->published_at)->format('d M Y') ?? '-' }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Diperbarui</div>
                            <div class="side-value">{{ optional($doc->updated_at)->format('d M Y') ?? '-' }}</div>
                        </div>

                        <div class="side-row">
                            <div class="side-label">Diunduh</div>
                            <div class="side-value">{{ number_format($doc->download_count ?? 0) }} x</div>
                        </div>
                    </div>

                    <div class="side-card side-card--actions">
                        <h3>Aksi Cepat</h3>

                        <a class="side-action" href="{{ route('services.index') }}">
                            Kembali ke Layanan
                            <span aria-hidden="true">→</span>
                        </a>

                        <a class="side-action" href="{{ route('legal.index') }}">
                            Lihat Semua Dokumen
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>

                </aside>

            </div>
        </div>
    </section>

@endsection
