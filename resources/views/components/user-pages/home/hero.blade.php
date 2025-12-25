<section class="hero has-bg"
    style="--hero-bg: url('{{ asset('assets/images/hero.jpg') }}');">
    <div class="hero-overlay"></div>
    <div class="hero-noise"></div>

    <div class="container hero-wrapper">
        <div class="hero-content">

            <div class="hero-kicker">Website Resmi</div>

            <h1 class="hero-title">
                {{ $schoolProfile->school_name ?? 'SMK Negeri' }}
            </h1>

            <p class="hero-tagline">
                {{ $schoolProfile->slogan ?? 'Unggul, Berkarakter, Berprestasi' }}
            </p>

            <p class="hero-description">
                {{ $schoolProfile->short_description ??
                'Website resmi sekolah sebagai pusat informasi, publikasi, dan layanan.' }}
            </p>

            <div class="hero-actions">
                <a href="#school-profile" class="hero-link">
                    Jelajahi profil sekolah
                    <span class="hero-arrow">→</span>
                </a>
            </div>

        </div>
    </div>
</section>
