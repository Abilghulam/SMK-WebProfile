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
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-shield-check-icon lucide-shield-check">
                                <path
                                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </span>
                        Informasi Resmi
                    </span>

                    @if (!empty(data_get($settings, 'phone')) || !empty(data_get($settings, 'email')))
                        <span class="svc-chip">
                            <span class="svc-chip-ico" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
                                    <path
                                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-contact-icon lucide-contact">
                                    <path d="M16 2v2" />
                                    <path d="M7 22v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2" />
                                    <path d="M8 2v2" />
                                    <circle cx="12" cy="11" r="3" />
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-school-icon lucide-school">
                                                <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                                                <path d="M18 5v16" />
                                                <path d="m4 6 7.106-3.79a2 2 0 0 1 1.788 0L20 6" />
                                                <path
                                                    d="m6 11-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11" />
                                                <path d="M6 5v16" />
                                                <circle cx="12" cy="9" r="2" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-file-icon lucide-file">
                                    <path
                                        d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-text-icon lucide-file-text">
                                        <path
                                            d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                        <path d="M10 9H8" />
                                        <path d="M16 13H8" />
                                        <path d="M16 17H8" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-form-icon lucide-form">
                                        <path d="M4 14h6" />
                                        <path d="M4 2h10" />
                                        <rect x="4" y="18" width="16" height="4" rx="1" />
                                        <rect x="4" y="6" width="16" height="4" rx="1" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-book-alert-icon lucide-book-alert">
                                        <path d="M12 13h.01" />
                                        <path d="M12 6v3" />
                                        <path
                                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-folder-open-icon lucide-folder-open">
                                        <path
                                            d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-folder-open-icon lucide-folder-open">
                                    <path
                                        d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-message-square-more-icon lucide-message-square-more">
                                        <path
                                            d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z" />
                                        <path d="M12 11h.01" />
                                        <path d="M16 11h.01" />
                                        <path d="M8 11h.01" />
                                    </svg>
                                </span>
                                Hubungi Admin
                            </a>
                        @endif

                        @if (!empty($email))
                            <a class="svc-side-action" href="mailto:{{ $email }}">
                                <span class="svc-side-action-ico" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-mail-icon lucide-mail">
                                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
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
