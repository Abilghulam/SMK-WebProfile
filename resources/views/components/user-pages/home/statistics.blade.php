<section class="school-statistics">
    <div class="container">

        {{-- Header --}}
        <div class="statistics-header">
            <div>
                <h2>Statistik Sekolah</h2>
                <p>Ringkasan data utama yang menggambarkan aktivitas dan kapasitas sekolah.</p>
            </div>

            @if (!empty($statistic?->academic_year))
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers">
                            <path
                                d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z" />
                            <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12" />
                            <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17" />
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
