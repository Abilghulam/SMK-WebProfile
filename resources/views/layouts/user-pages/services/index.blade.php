@extends('layouts.app')

@section('title', 'Layanan | ' . data_get($settings, 'site_name', 'SMK Negeri'))
@section('meta_description',
    'Informasi layanan sekolah: kontak, lokasi, dan dokumen legalitas untuk kebutuhan
    administrasi.')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.shared.hero', [
        'kicker' => 'Layanan',
        'title' => 'Layanan Sekolah',
        'subtitle' => 'Kontak resmi, lokasi sekolah, serta dokumen legalitas dan kebutuhan administrasi.',
    ])

    <section class="services-landing svc-gov">
        <div class="container">

            {{-- Breadcrumb / Top meta --}}
            <div class="svc-topbar">
                <div class="breadcrumb-legal">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="crumb-sep">/</span>
                    <span class="crumb-current">Layanan</span>
                </div>

                <div class="svc-topbar-badges">
                    <span class="svc-chip">
                        <span class="svc-chip-ico" aria-hidden="true">
                            {{-- shield/check --}}
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4z" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M8.5 12l2.2 2.2L15.8 9" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        Informasi Resmi
                    </span>

                    @if (!empty(data_get($settings, 'phone')) || !empty(data_get($settings, 'email')))
                        <span class="svc-chip">
                            <span class="svc-chip-ico" aria-hidden="true">
                                {{-- phone --}}
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M6.5 3.8h3l1.2 4-1.6 1.3c1.2 2.5 3.2 4.6 5.8 5.8l1.3-1.6 4 1.2v3c0 1-0.7 1.8-1.7 1.9-8 .6-14.5-5.9-13.9-13.9.1-1 .9-1.7 1.9-1.7z"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            Layanan Resmi
                        </span>
                    @endif
                </div>
            </div>

            <div class="services-grid" id="kontak">

                {{-- MAIN --}}
                <div class="services-main">

                    {{-- CONTACT + MAPS --}}
                    <div class="svc-card svc-card--panel">
                        <div class="svc-panel-head">
                            <div class="svc-panel-badge" aria-hidden="true">
                                {{-- id card --}}
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 7.5c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2v9c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2v-9z"
                                        stroke="currentColor" stroke-width="1.8" />
                                    <path d="M7 10h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                    <path d="M7 13h7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                    <path d="M16.5 13.5c1 0 1.8-.8 1.8-1.8S17.5 10 16.5 10s-1.8.8-1.8 1.7.8 1.8 1.8 1.8z"
                                        stroke="currentColor" stroke-width="1.6" />
                                </svg>
                            </div>

                            <div class="svc-panel-title">
                                <h2 class="svc-title">Kontak & Lokasi</h2>
                                <p class="svc-subtitle">
                                    Gunakan informasi di bawah ini untuk komunikasi resmi, koordinasi kegiatan, dan
                                    kunjungan.
                                </p>
                            </div>

                            <div class="svc-panel-mark" aria-hidden="true">
                                <span class="svc-mark-label">UNIT</span>
                                <span class="svc-mark-value">Humas</span>
                            </div>
                        </div>

                        <div class="svc-contact-grid">

                            {{-- INFO --}}
                            <div class="svc-info">
                                @php
                                    $siteName = data_get($settings, 'site_name', 'SMK Negeri');
                                    $address = data_get($settings, 'address');
                                    $phone = data_get($settings, 'phone');
                                    $email = data_get($settings, 'email');
                                @endphp

                                <div class="svc-info-item">
                                    <div class="svc-info-line">
                                        <span class="svc-icon" aria-hidden="true">
                                            {{-- building --}}
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M4 20h16" stroke="currentColor" stroke-width="1.8"
                                                    stroke-linecap="round" />
                                                <path d="M6 20V6a2 2 0 012-2h8a2 2 0 012 2v14" stroke="currentColor"
                                                    stroke-width="1.8" />
                                                <path d="M9 8h2M9 11h2M9 14h2M13 8h2M13 11h2M13 14h2" stroke="currentColor"
                                                    stroke-width="1.8" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        Identitas
                                    </div>

                                    <div class="svc-info-body">
                                        <div class="svc-kv">
                                            <div class="svc-k">Nama Sekolah</div>
                                            <div class="svc-v">{{ $siteName }}</div>
                                        </div>

                                        <div class="svc-kv">
                                            <div class="svc-k">Alamat</div>
                                            <div class="svc-v">
                                                {{ $address ?: '-' }}
                                            </div>
                                        </div>

                                        <div class="svc-kv svc-kv--row">
                                            <div class="svc-kv-col">
                                                <div class="svc-k">Telepon</div>
                                                <div class="svc-v">
                                                    @if (!empty($phone))
                                                        <a class="svc-link"
                                                            href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="svc-kv-col">
                                                <div class="svc-k">Email</div>
                                                <div class="svc-v">
                                                    @if (!empty($email))
                                                        <a class="svc-link"
                                                            href="mailto:{{ $email }}">{{ $email }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- MAPS --}}
                            <div class="svc-maps">
                                <div class="svc-maps-head">
                                    <div class="svc-label">Peta Lokasi</div>
                                    <div class="svc-maps-mini">
                                        <span class="svc-mini-dot" aria-hidden="true"></span>
                                        <span class="svc-mini-text">Google Maps</span>
                                    </div>
                                </div>

                                <div class="svc-maps-frame">
                                    @if (!empty(data_get($settings, 'maps_embed')))
                                        {!! data_get($settings, 'maps_embed') !!}
                                    @else
                                        <div class="svc-empty">Peta belum tersedia.</div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- LEGAL PREVIEW --}}
                    <div class="svc-card svc-card--panel">
                        <div class="svc-panel-head">
                            <div class="svc-panel-badge" aria-hidden="true">
                                {{-- file --}}
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"
                                        stroke="currentColor" stroke-width="1.8" />
                                    <path d="M14 3v5h5" stroke="currentColor" stroke-width="1.8"
                                        stroke-linejoin="round" />
                                    <path d="M8 12h8M8 15h8" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <div class="svc-panel-title">
                                <h2 class="svc-title">Legalitas Sekolah</h2>
                                <p class="svc-subtitle">
                                    Dokumen legalitas dan template administrasi. Akses daftar lengkap melalui halaman
                                    legalitas.
                                </p>
                            </div>

                            <div class="svc-panel-mark" aria-hidden="true">
                                <span class="svc-mark-label">AKSES</span>
                                <span class="svc-mark-value">Unduhan</span>
                            </div>
                        </div>

                        <div class="svc-legal-list">
                            <div class="svc-legal-item">
                                <div class="svc-legal-ico" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M8 7h8M8 11h8M8 15h6" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" />
                                        <path d="M6 3h8l4 4v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"
                                            stroke="currentColor" stroke-width="1.8" />
                                    </svg>
                                </div>
                                <div class="svc-legal-text">
                                    <div class="svc-legal-name">Dokumen Legalitas</div>
                                    <div class="svc-legal-desc">SK, informasi akreditasi, dan dokumen pendukung lainnya.
                                    </div>
                                </div>
                            </div>

                            <div class="svc-legal-item">
                                <div class="svc-legal-ico" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M7 7h10M7 11h10M7 15h7" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" />
                                        <path d="M5 4h14v16H5V4z" stroke="currentColor" stroke-width="1.8" />
                                    </svg>
                                </div>
                                <div class="svc-legal-text">
                                    <div class="svc-legal-name">Template Surat</div>
                                    <div class="svc-legal-desc">Contoh surat pemberitahuan, undangan, dan format
                                        administrasi.</div>
                                </div>
                            </div>

                            <div class="svc-legal-item">
                                <div class="svc-legal-ico" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 22a10 10 0 110-20 10 10 0 010 20z" stroke="currentColor"
                                            stroke-width="1.8" />
                                    </svg>
                                </div>
                                <div class="svc-legal-text">
                                    <div class="svc-legal-name">Informasi Administrasi</div>
                                    <div class="svc-legal-desc">Alur pengajuan surat, estimasi waktu, dan kanal layanan.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="svc-actions svc-actions--legal">
                            <a class="svc-btn" href="{{ route('legal.index') }}">
                                <span class="svc-btn-ico" aria-hidden="true">
                                    {{-- folder --}}
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M3.5 7.5h6l2 2H20a2 2 0 012 2v7a2 2 0 01-2 2H5.5a2 2 0 01-2-2v-11a2 2 0 012-2z"
                                            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Buka Legalitas & Dokumen
                            </a>
                        </div>
                    </div>

                </div>

                {{-- SIDE PANEL --}}
                <aside class="services-side">

                    <div class="svc-side-card svc-side-card--gov">
                        <h3 class="svc-side-title">Ringkasan Layanan</h3>

                        <div class="svc-side-row">
                            <div class="svc-side-label">Jam Layanan</div>
                            <div class="svc-side-value">Senin – Jumat (07.00-15.00)</div>
                        </div>

                        <div class="svc-side-row">
                            <div class="svc-side-label">Tanggapan</div>
                            <div class="svc-side-value">Sesuai antrean & prioritas</div>
                        </div>

                        <div class="svc-side-row">
                            <div class="svc-side-label">Kanal</div>
                            <div class="svc-side-value">Telepon, Email, WhatsApp</div>
                        </div>

                        <p class="svc-side-text">
                            Untuk kebutuhan surat menyurat, gunakan menu Legalitas agar format dokumen sesuai standar
                            sekolah.
                        </p>

                        <a class="svc-side-action" href="{{ route('legal.index') }}">
                            <span class="svc-side-action-ico" aria-hidden="true">
                                {{-- folder --}}
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M3.5 7.5h6l2 2H20a2 2 0 012 2v7a2 2 0 01-2 2H5.5a2 2 0 01-2-2v-11a2 2 0 012-2z"
                                        stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                </svg>
                            </span>
                            Legalitas & Dokumen
                        </a>
                    </div>

                    <div class="svc-side-card svc-side-card--contact">
                        <h3 class="svc-side-title">Kontak Resmi</h3>

                        <div class="svc-side-row">
                            <div class="svc-side-label">Telepon</div>
                            <div class="svc-side-value">{{ data_get($settings, 'phone', '-') }}</div>
                        </div>

                        <div class="svc-side-row">
                            <div class="svc-side-label">Email</div>
                            <div class="svc-side-value">{{ data_get($settings, 'email', '-') }}</div>
                        </div>

                        <div class="svc-side-row">
                            <div class="svc-side-label">Alamat</div>
                            <div class="svc-side-value">
                                {{ \Illuminate\Support\Str::limit((string) data_get($settings, 'address', '-'), 100) }}
                            </div>
                        </div>

                        <div class="svc-note">
                            Pastikan mencantumkan identitas dan tujuan ketika menghubungi sekolah (contoh: nama,
                            asal, keperluan).
                        </div>

                        @php
                            $wa = data_get($settings, 'whatsapp_url');
                            $mapsUrl = data_get($settings, 'maps_url');
                        @endphp

                        @if (!empty($wa))
                            <a class="svc-side-action" href="{{ $wa }}" target="_blank" rel="noopener">
                                <span class="svc-side-action-ico" aria-hidden="true">
                                    {{-- chat --}}
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M20 15a4 4 0 01-4 4H8l-4 3V7a4 4 0 014-4h8a4 4 0 014 4v8z"
                                            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Hubungi Admin
                            </a>
                        @endif

                        @if (!empty($email))
                            <a class="svc-side-action" href="mailto:{{ $email }}">
                                <span class="svc-side-action-ico" aria-hidden="true">
                                    {{-- mail --}}
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M4 6h16v12H4V6z" stroke="currentColor" stroke-width="1.8" />
                                        <path d="M4 7l8 6 8-6" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Kirim Email
                            </a>
                        @endif
                    </div>

                </aside>

            </div>
        </div>
    </section>

@endsection
