@php
    // defaults aman
    $title = $title ?? 'Halaman';
    $subtitle = $subtitle ?? null;
    $bgImage = $bgImage ?? null; // contoh: asset('assets/images/hero-bg.jpg')
@endphp

<section class="page-hero {{ $bgImage ? 'has-bg' : '' }}"
    @if($bgImage) style="--page-hero-bg: url('{{ $bgImage }}');" @endif
>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-noise"></div>

    <div class="container page-hero-wrap">
        <div class="page-hero-content">

            @if(!empty($kicker))
                <div class="page-hero-kicker">{{ $kicker }}</div>
            @endif

            <h1 class="page-hero-title">{{ $title }}</h1>

            @if(!empty($subtitle))
                <p class="page-hero-subtitle">{{ $subtitle }}</p>
            @endif

        </div>
    </div>
</section>
