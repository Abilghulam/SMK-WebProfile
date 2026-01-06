@extends('layouts.app')

@section('title', 'Program Keahlian | SMK Negeri 9 Muaro Jambi')
@section('meta_description', 'Informasi program keahlian di SMK Negeri 9 Muaro Jambi')

@section('content')

    @include('components.user-pages.shared.hero', [
        'kicker' => 'Akademik',
        'title' => 'Program Keahlian',
        'subtitle' =>
            'Informasi jurusan dan kompetensi keahlian di ' .
            ($schoolProfile->school_name ?? 'SMK Negeri 9 Muaro Jambi') .
            '.',
        'bgImage' => asset('assets/images/hero-bg.jpg'),
    ])

    {{-- ===== KONTEN UTAMA PROGRAM KEAHLIAN ===== --}}
    <section class="page-section departments-section">
        <div class="container">

            <div class="section-header section-header--left">
                <h2>Daftar Program Keahlian</h2>
                <p>
                    Program keahlian dirancang untuk membekali peserta didik
                    dengan kompetensi sesuai kebutuhan dunia kerja dan industri.
                </p>
            </div>

            @if ($departments->count())
                <div class="departments-grid">

                    @foreach ($departments as $department)
                        <article class="department-card">

                            {{-- Image --}}
                            <div class="department-image">
                                @if ($department->cover_url)
                                    <img src="{{ asset($department->cover_url) }}" alt="{{ $department->name }}"
                                        loading="lazy">
                                @else
                                    <div class="image-placeholder">
                                        <span>{{ strtoupper(substr($department->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="department-content">
                                <h3 class="department-title">
                                    {{ $department->name }}
                                </h3>

                                <p class="department-desc">
                                    {{ $department->short_description ?? \Illuminate\Support\Str::limit(strip_tags($department->description), 120) }}
                                </p>

                                <a href="{{ route('departments.show', $department->slug) }}" class="department-link">
                                    Lihat Detail
                                    <span style="margin-top: 8px;" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                            <path d="m9 18 6-6-6-6" />
                                        </svg>
                                    </span>
                                </a>
                            </div>

                        </article>
                    @endforeach

                </div>
            @else
                <div class="empty-state">
                    <p>Data program keahlian belum tersedia.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
