<section class="school-profile" id="school-profile">
    <div class="container">

        {{-- Header --}}
        <div class="section-header section-header--left">
            <h2>Selamat Datang di Website {{ $schoolProfile->school_name ?? 'SMK' }}</h2>
            <p>Mengenal lebih dekat tentang {{ $schoolProfile->school_name ?? 'SMK' }}</p>
        </div>

        <div class="profile-content profile-grid">

            {{-- ROW 1 : Sejarah + Video (SATU BOX) --}}
            <div class="card card--wide">
                <div class="row1-grid">

                    <div class="row1-text">
                        <div class="eyebrow">Profil Sekolah</div>
                        <h3 class="card-title">Sejarah Singkat</h3>
                        <p class="card-text">
                            {{ $schoolProfile->history ?? 'Informasi sejarah sekolah akan ditampilkan di sini.' }}
                        </p>
                    </div>

                    <div class="row1-media">
                        @if(!empty($schoolProfile?->youtube_url))
                            <div class="video-embed">
                                <iframe
                                    src="{{ $schoolProfile->youtube_url }}"
                                    title="Video Profil Sekolah"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @else
                            <div class="media-empty">
                                <p>Video profil sekolah belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ROW 2 KIRI : Visi + Misi (SATU BOX) --}}
            <div class="card card--left">
                <div class="card-headline">
                    <h3 class="card-title">Visi & Misi</h3>
                </div>

                <div class="vm-block">
                    <h4 class="sub-title">Visi</h4>
                    <p class="card-text">
                        {{ $schoolProfile->vision ?? 'Visi sekolah belum tersedia.' }}
                    </p>
                </div>

                <div class="vm-block">
                    <h4 class="sub-title">Misi</h4>

                    <ul class="mission-list">
                        @if(!empty($schoolProfile?->mission))
                            @foreach(preg_split("/\r\n|\n|\r/", trim($schoolProfile->mission)) as $mission)
                                @if(trim($mission) !== '')
                                    <li>{{ $mission }}</li>
                                @endif
                            @endforeach
                        @else
                            <li>Misi sekolah belum tersedia.</li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- ROW 2 KANAN : NPSN / Akreditasi / Kurikulum (3 BOX) --}}
            <div class="info-stack">
                <div class="info-card">
                    <div class="info-label">NPSN</div>
                    <div class="info-value">{{ $schoolProfile->npsn ?? '-' }}</div>
                </div>

                <div class="info-card">
                    <div class="info-label">Akreditasi</div>
                    <div class="info-value">{{ $schoolProfile->accreditation ?? '-' }}</div>
                </div>

                <div class="info-card">
                    <div class="info-label">Kurikulum</div>
                    <div class="info-value">{{ $schoolProfile->curriculum ?? '-' }}</div>
                </div>
            </div>

        </div>

    </div>
</section>
