<section class="school-statistics">
    <div class="container">

        {{-- Header --}}
        <div class="statistics-header">
            <div>
                <h2>Statistik Sekolah</h2>
                <p>Ringkasan data utama yang menggambarkan aktivitas dan kapasitas sekolah.</p>
            </div>

            @if(!empty($statistic?->academic_year))
                <div class="stat-year-badge">
                    Tahun Ajaran <strong>{{ $statistic->academic_year }}</strong>
                </div>
            @endif
        </div>

        <div class="statistics-wrapper">

            {{-- Siswa --}}
            <div class="stat-box">
                <div class="stat-top">
                    <div class="stat-icon" aria-hidden="true">
                        {{-- user/group icon --}}
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M16 11c1.656 0 3-1.567 3-3.5S17.656 4 16 4s-3 1.567-3 3.5S14.344 11 16 11Z" />
                            <path d="M8 11c1.656 0 3-1.567 3-3.5S9.656 4 8 4 5 5.567 5 7.5 6.344 11 8 11Z" />
                            <path d="M16 13c-1.505 0-2.83.52-3.71 1.318C13.397 15.057 14 16.01 14 17.1V19h8v-1.5c0-2.485-2.687-4.5-6-4.5Z" />
                            <path d="M8 13c-3.313 0-6 2.015-6 4.5V19h12v-1.4c0-2.54-2.687-4.6-6-4.6Z" />
                        </svg>
                    </div>
                    <p class="stat-label">Siswa</p>
                </div>

                <h3 class="stat-number" data-count="{{ $statistic->total_students ?? 0 }}">0</h3>
                <p class="stat-sub">Jumlah peserta didik aktif</p>
            </div>

            {{-- Guru --}}
            <div class="stat-box">
                <div class="stat-top">
                    <div class="stat-icon" aria-hidden="true">
                        {{-- badge/teacher icon --}}
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 12c2.761 0 5-2.239 5-5S14.761 2 12 2 7 4.239 7 7s2.239 5 5 5Z" />
                            <path d="M4 22v-2c0-3.314 3.582-6 8-6s8 2.686 8 6v2H4Z" />
                        </svg>
                    </div>
                    <p class="stat-label">Guru</p>
                </div>

                <h3 class="stat-number" data-count="{{ $statistic->total_teachers ?? 0 }}">0</h3>
                <p class="stat-sub">Tenaga pendidik & staf</p>
            </div>

            {{-- Jurusan --}}
            <div class="stat-box">
                <div class="stat-top">
                    <div class="stat-icon" aria-hidden="true">
                        {{-- grid/icon --}}
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M4 4h7v7H4V4Z" />
                            <path d="M13 4h7v7h-7V4Z" />
                            <path d="M4 13h7v7H4v-7Z" />
                            <path d="M13 13h7v7h-7v-7Z" />
                        </svg>
                    </div>
                    <p class="stat-label">Jurusan</p>
                </div>

                <h3 class="stat-number" data-count="{{ $statistic->total_departments ?? 0 }}">0</h3>
                <p class="stat-sub">Program keahlian tersedia</p>
            </div>

        </div>

    </div>
</section>
