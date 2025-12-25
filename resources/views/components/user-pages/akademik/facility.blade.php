@extends('layouts.app')

@section('title', 'Fasilitas Sekolah | SMK Negeri 9 Muaro Jambi')
@section('meta_description', 'Informasi fasilitas sekolah di SMK Negeri 9 Muaro Jambi')

@section('content')

    @include('components.user-pages.shared.hero', [
        'kicker' => 'Akademik',
        'title' => 'Fasilitas Sekolah',
        'subtitle' => 'Sarana dan prasarana penunjang pembelajaran.',
        'bgImage' => asset('assets/images/hero-bg.jpg')
    ])

    {{-- ===== KONTEN UTAMA FASILITAS ===== --}}
    <section class="page-section facilities-section">
        <div class="container">

            <div class="section-header section-header--left">
                <h2>Daftar Fasilitas</h2>
                <p>
                    Fasilitas sekolah disiapkan untuk menunjang pembelajaran, praktik, kegiatan organisasi,
                    dan pengembangan keterampilan siswa.
                </p>
            </div>

            @if($facilities->count())
                <div class="facilities-grid">

                    @foreach($facilities as $facility)
                        <article class="facility-card">

                            <div class="facility-media">
                                @if($facility->image)
                                    <img
                                        src="{{ asset($facility->image) }}"
                                        alt="{{ $facility->name }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="facility-placeholder">
                                        <span>{{ strtoupper(substr($facility->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="facility-body">
                                <h3 class="facility-title">{{ $facility->name }}</h3>

                                <p class="facility-desc">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($facility->description ?? ''), 160) }}
                                </p>
                            </div>

                        </article>
                    @endforeach

                </div>
            @else
                <div class="empty-state">
                    <p>Data fasilitas sekolah belum tersedia.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
