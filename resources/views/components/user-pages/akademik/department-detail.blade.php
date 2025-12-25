@extends('layouts.app')

{{-- ===== PAGE META ===== --}}
@section('title', ($department->name ?? 'Program Keahlian') . ' | SMK Negeri')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($department->short_description ?? $department->description ?? ''), 155))

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker'   => 'Akademik',
        'title'    => $department->name ?? 'Program Keahlian',
        'subtitle' => $department->short_description ?? 'Informasi lengkap program keahlian.',
        'bgImage'  => $department->image ? asset($department->image) : asset('assets/images/hero-bg.jpg')
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

                    @if($department->image)
                        <div class="detail-cover">
                            <img src="{{ asset($department->image) }}" alt="{{ $department->name }}" loading="lazy">
                        </div>
                    @endif

                    <div class="detail-card">
                        <h2 class="detail-title">Profil Program Keahlian</h2>

                        @if(!empty($department->description))
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

                                    @if(!empty($department->competencies) && is_array($department->competencies))
                                        <ul class="info-list">
                                            @foreach($department->competencies as $item)
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

                                    @if(!empty($department->career_opportunities) && is_array($department->career_opportunities))
                                        <ul class="info-list">
                                            @foreach($department->career_opportunities as $item)
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
                        <a href="{{ route('departments.index') }}" class="btn-back">
                            Kembali ke daftar program
                        </a>
                    </div>

                </article>

                {{-- Side Panel --}}
                <aside class="detail-side">

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

                    @if(!empty($department->short_description))
                        <div class="side-card side-card--note">
                            <h3>Ringkasan</h3>
                            <p>{{ $department->short_description }}</p>
                        </div>
                    @endif

                </aside>

            </div>

        </div>
    </section>
@endsection
