@extends('layouts.app')

@section('title', 'Legalitas & Dokumen | ' . data_get($settings ?? null, 'site_name', 'SMK Negeri'))
@section('meta_description', 'Unduh dokumen legalitas dan template administrasi sekolah.')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Layanan',
        'title' => 'Legalitas & Dokumen',
        'subtitle' => 'Dokumen resmi sekolah dan template kebutuhan administrasi yang dapat diunduh.',
    ])

    <section class="page-section services-landing legal-page">
        <div class="container">

            {{-- Topbar (Breadcrumb + Total) --}}
            <div class="legal-topbar">
                <div class="breadcrumb-legal">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="crumb-sep">/</span>
                    <a href="{{ route('services.index') }}">Layanan</a>
                    <span class="crumb-sep">/</span>
                    <span class="crumb-current">Legalitas & Dokumen</span>
                </div>

                <a class="legal-action legal-action--back" href="{{ route('services.index') }}">
                    <svg class="legal-action-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>Kembali ke Layanan</span>
                </a>
            </div>

            @if ($docs->flatten(1)->count() === 0)
                <div class="legal-empty">
                    <div class="legal-empty-inner">
                        <h3>Belum ada dokumen</h3>
                        <p>Dokumen legalitas/unduhan akan ditampilkan di halaman ini ketika sudah ditambahkan oleh admin.
                        </p>
                    </div>
                </div>
            @else
                {{-- Category Sections --}}
                @foreach ($docs as $category => $items)
                    <div class="legal-section legal-section--panel">

                        <div class="legal-section-head">
                            <div class="legal-section-title">
                                <h2>{{ \Illuminate\Support\Str::headline($category) }}</h2>
                                <p>{{ $items->count() }} dokumen</p>
                            </div>
                        </div>

                        <div class="legal-grid">
                            @foreach ($items as $doc)
                                @php
                                    $fileType = strtolower($doc->file_type ?? '');
                                    $badge = $fileType ?: 'Dokumen';
                                    $downloadUrl = $doc->download_url;
                                    $hasDownload = !empty($downloadUrl);
                                @endphp

                                <article class="legal-card">

                                    <div class="legal-card-head">
                                        @php
                                            $fileType = strtolower($doc->file_type ?? '');
                                            $fileType =
                                                $fileType ?:
                                                strtolower(pathinfo($doc->file_path ?? '', PATHINFO_EXTENSION));
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
                                        <div class="legal-filebadge legal-filebadge--{{ $fileClass }}"
                                            aria-hidden="true">
                                            <svg class="legal-filebadge-ic" viewBox="0 0 24 24" fill="none">
                                                <path d="M8 3h6l4 4v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                                    stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                                <path d="M14 3v5h5" stroke="currentColor" stroke-width="1.8"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            <span class="legal-filebadge-label">
                                                {{ $fileLabel }}
                                            </span>
                                        </div>

                                        <div class="legal-card-title">
                                            <h3>
                                                {{ $doc->title }}
                                            </h3>

                                            <div class="legal-card-sub">
                                                @if (!empty($doc->published_at))
                                                    <span class="legal-date">
                                                        {{ optional($doc->published_at)->format('d M Y') }}
                                                    </span>
                                                @endif

                                                @if (!is_null($doc->download_count))
                                                    <span class="dot"></span>
                                                    <span class="legal-meta-item">{{ number_format($doc->download_count) }}
                                                        Unduhan</span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    @if (!empty($doc->description))
                                        <p class="legal-desc">{{ $doc->description }}</p>
                                    @endif

                                    <div class="legal-card-actions">
                                        <a class="legal-link" href="{{ route('legal.show', $doc->slug) }}">
                                            Lihat Detail
                                            <span aria-hidden="true">→</span>
                                        </a>

                                        @if ($hasDownload)
                                            <a class="legal-action legal-action--download"
                                                href="{{ route('legal.download', $doc->slug) }}" target="_blank"
                                                rel="noopener">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                </svg>

                                                <span>Unduh</span>
                                            </a>
                                        @else
                                            <span class="legal-muted">File belum tersedia</span>
                                        @endif
                                    </div>

                                </article>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            @endif

        </div>
    </section>

@endsection
