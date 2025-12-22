<section class="hero">
    <div class="container hero-wrapper">

        <div class="hero-content">
            <h1 class="hero-title">
                {{ $schoolProfile->school_name ?? 'SMK Negeri' }}
            </h1>

            <h2 class="hero-tagline">
                {{ $schoolProfile->slogan ?? 'Unggul, Berkarakter, Berprestasi' }}
            </h2>

            <p class="hero-description">
                {{ $schoolProfile->short_description ?? 
                'Website resmi SMK Negeri sebagai pusat informasi, publikasi, dan layanan sekolah.' }}
            </p>

            <div class="hero-actions">
                <a href="{{ url('/profil') }}" class="btn btn-primary">
                    Profil Sekolah
                </a>
                <a href="{{ url('/ppdb') }}" class="btn btn-outline">
                    PPDB
                </a>
            </div>
        </div>

    </div>
</section>
